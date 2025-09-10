<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LearningObjective;
use App\Models\Phase;
use App\Models\GradeLevel; // Import model ini
use App\Models\Subject;   // Import model ini
use App\Models\LearningOutcome; // Import model ini
use App\Http\Traits\TeacherAssignmentsTrait; // <-- 1. IMPORT TRAIT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LearningObjectiveController extends Controller
{
    use TeacherAssignmentsTrait;
    /**
     * Menampilkan daftar Tujuan Pembelajaran yang sudah dibuat oleh guru.
     */
    public function index()
    {
    $learningObjectives = LearningObjective::where('user_id', Auth::id())
        ->with(['phase', 'gradeLevel', 'subject', 'kktp']) // <-- TAMBAHKAN 'kktp' DI SINI
        ->latest()
        ->paginate(10);

    return view('guru.learning_objectives.index', compact('learningObjectives'));
    }

    /**
     * Menampilkan form untuk membuat Tujuan Pembelajaran baru.
     */
    public function create()
    {
        // 3. Ambil data penugasan
        $assignments = $this->getTeacherAssignments();

        // Jika guru belum punya tugas, jangan tampilkan apa-apa
        if (empty($assignments['subject_ids']) || empty($assignments['grade_level_ids'])) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki penugasan mengajar. Hubungi Admin.');
        }

        // Ambil ID Fase berdasarkan Tingkat Kelas yang diajar
        $phaseIds = GradeLevel::whereIn('id', $assignments['grade_level_ids'])->pluck('phase_id')->unique();

        // 4. Ambil data yang sudah difilter
        $phases = Phase::whereIn('id', $phaseIds)->get();

        // Kirim data penugasan ke view untuk digunakan oleh API
        $assignedSubjectIds = $assignments['subject_ids'];
        $assignedGradeLevelIds = $assignments['grade_level_ids'];

        return view('guru.learning_objectives.create', compact('phases', 'assignedSubjectIds', 'assignedGradeLevelIds'));
    }

    /**
     * Menyimpan Tujuan Pembelajaran yang baru ke database.
     */
    public function store(Request $request)
    {
    $request->validate([
        'phase_id' => 'required|exists:phases,id',
        'grade_level_id' => 'required|exists:grade_levels,id',
        'subject_id' => 'required|exists:subjects,id',
        'scope' => 'required|string',
        'objectives' => 'required|array|min:1',
        'objectives.*' => 'required|string',
        'learning_outcomes' => 'required|array', // Validasi bahwa checkbox elemen dipilih
    ]);

    // Ambil ID elemen pertama yang dipilih sebagai referensi utama
    $mainElementId = $request->learning_outcomes[0] ?? null;

    foreach ($request->objectives as $description) {
        LearningObjective::create([
            'user_id' => Auth::id(),
            'phase_id' => $request->phase_id,
            'grade_level_id' => $request->grade_level_id,
            'subject_id' => $request->subject_id,
            'element_id' => $mainElementId, // <-- SIMPAN ID ELEMEN DI SINI
            'scope' => $request->scope,
            'description' => $description,
        ]);
    }

    return redirect()->route('teacher.learning-objectives.index')->with('success', 'Tujuan Pembelajaran berhasil disimpan.');
    }

    public function getGradeLevels(Request $request, $phase_id)
    {
        $assignments = $this->getTeacherAssignments();
        return GradeLevel::where('phase_id', $phase_id)
                         ->whereIn('id', $assignments['grade_level_ids'])
                         ->get();
    }

    public function getSubjects()
    {
        $assignments = $this->getTeacherAssignments();
        return Subject::whereIn('id', $assignments['subject_ids'])->get();
    }

    public function getElementsAndCp(Request $request)
    {
        // Validasi bahwa guru memang mengajar mapel & tingkat kelas ini
        $assignments = $this->getTeacherAssignments();
        $phase = Phase::find($request->phase_id);
        $gradeLevelIdsInPhase = $phase->gradeLevels()->pluck('id')->toArray();
        
        $isAuthorized = in_array($request->subject_id, $assignments['subject_ids']) &&
                        !empty(array_intersect($gradeLevelIdsInPhase, $assignments['grade_level_ids']));

        if (!$isAuthorized) {
            return response()->json([], 403); // Forbidden
        }

        return LearningOutcome::where('phase_id', $request->phase_id)
                                ->where('subject_id', $request->subject_id)
                                ->with('element')
                                ->get();
    }

    /**
     * Logika untuk memanggil AI Gemini.
     */
    public function generateAi(Request $request)
    {
        $request->validate([
            'capaian_pembelajaran' => 'required|string',
            'scope' => 'required|string',
        ]);

        $capaianPembelajaran = $request->capaian_pembelajaran;
        $scope = $request->scope;

        // Prompt yang detail sesuai permintaan Anda
        $prompt = "Anda adalah seorang ahli kurikulum dan pedagogi. Berdasarkan Capaian Pembelajaran (CP) dan ruang lingkup materi yang diberikan, buatlah daftar Tujuan Pembelajaran (TP) yang relevan.
        
        Setiap TP harus dikembangkan dari CP dan mencakup dua komponen utama:
        1.  **Kompetensi:** Kemampuan yang dapat diukur, menggunakan kata kerja operasional (contoh: menganalisis, membandingkan, menciptakan, mengidentifikasi, menjelaskan).
        2.  **Lingkup Materi:** Konten atau konsep utama yang spesifik dari ruang lingkup materi yang diberikan.

        Pastikan TP yang dihasilkan fokus pada materi esensial dan dapat dicapai oleh siswa hingga akhir fase.

        **Capaian Pembelajaran (CP):**
        \"$capaianPembelajaran\"

        **Ruang Lingkup Materi:**
        \"$scope\"

        Tolong berikan hasilnya dalam format JSON yang ketat, dengan struktur seperti ini: {\"objectives\": [{\"description\": \"Tujuan Pembelajaran 1\"}, {\"description\": \"Tujuan Pembelajaran 2\"}]}";

        // Persiapan untuk memanggil Gemini API
        $apiKey = "AIzaSyDHzZgjbAUhYTlqxucYPtqUFDvM_ep9xBM"; // Dikosongkan, akan diisi oleh sistem Canvas
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=" . $apiKey;

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        try {
            $response = Http::post($apiUrl, $payload);

            if ($response->successful()) {
                // Ekstrak teks dari respons dan coba bersihkan
                $rawText = $response->json('candidates.0.content.parts.0.text');
                $cleanedJson = trim(str_replace(['```json', '```'], '', $rawText));
                
                $data = json_decode($cleanedJson, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($data['objectives'])) {
                    return response()->json($data);
                } else {
                    // Jika JSON tidak valid, kembalikan error
                    return response()->json(['error' => 'Gagal mem-parsing respons dari AI.', 'raw' => $rawText], 500);
                }
            } else {
                return response()->json(['error' => 'Gagal menghubungi AI Service.', 'details' => $response->body()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}