<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\LessonPlan;
use App\Models\TeachingFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class LessonPlanController extends Controller
{
    public function index()
{
    $lessonPlans = LessonPlan::where('user_id', Auth::id())
        ->with(['subject', 'gradeLevel']) // <-- Baris ini memastikan data relasi dimuat
        ->latest()
        ->paginate(10);

    return view('guru.lesson_plans.index', compact('lessonPlans'));
}

    public function start()
    {
        $teachingFlows = TeachingFlow::where('user_id', Auth::id())->with(['subject', 'gradeLevel'])->get();
        return view('guru.lesson_plans.start', compact('teachingFlows'));
    }

    public function create(Request $request)
    {
        $request->validate(['teaching_flow_id' => 'required|exists:teaching_flows,id']);
        
        $teachingFlow = TeachingFlow::with('learningObjectives.element')
            ->where('user_id', Auth::id())
            ->findOrFail($request->teaching_flow_id);

        return view('guru.lesson_plans.create', compact('teachingFlow'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'subject_id' => 'required|exists:subjects,id',
        'grade_level_id' => 'required|exists:grade_levels,id',
        'academic_year' => 'required|string|max:20', // Validasi baru
        'semester' => 'required|string|in:Ganjil,Genap', // Validasi baru
        'duration_in_minutes' => 'nullable|integer',
        'initial_assessment' => 'nullable|string',
        'graduate_profile_dimensions' => 'nullable|array',
        'pedagogical_practices' => 'nullable|string',
        'partnership' => 'nullable|string',
        'learning_activities' => 'nullable|array',
        'assessment' => 'nullable|array',
        'learning_objective_ids' => 'required|array|min:1',
        'learning_objective_ids.*' => 'exists:learning_objectives,id',
    ]);

    DB::transaction(function () use ($validated) {
        $lessonPlan = LessonPlan::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'subject_id' => $validated['subject_id'],
            'grade_level_id' => $validated['grade_level_id'],
            'academic_year' => $validated['academic_year'], // Simpan data baru
            'semester' => $validated['semester'], // Simpan data baru
            'duration_in_minutes' => $validated['duration_in_minutes'] ?? null,
            'initial_assessment' => $validated['initial_assessment'] ?? null,
            'graduate_profile_dimensions' => $validated['graduate_profile_dimensions'] ?? null,
            'pedagogical_practices' => $validated['pedagogical_practices'] ?? null,
            'partnership' => $validated['partnership'] ?? null,
            'learning_activities' => $validated['learning_activities'] ?? null,
            'assessment' => $validated['assessment'] ?? null,
        ]);

        $lessonPlan->learningObjectives()->attach($validated['learning_objective_ids']);
    });

    return redirect()->route('teacher.lesson-plans.index')->with('success', 'Modul Ajar berhasil dibuat!');
}


    /**
 * Menampilkan detail satu Modul Ajar.
 */
public function show(LessonPlan $lessonPlan)
    {
        // ==================== PERUBAHAN DI SINI ====================
        // Izinkan akses jika pengguna adalah pemilik ATAU seorang kepala sekolah
        if ($lessonPlan->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
            abort(403);
        }
        // ==========================================================

        $lessonPlan->load([
            'user', 
            'subject', 
            'gradeLevel.phase',
            'learningObjectives'
        ]);

        return view('guru.lesson_plans.show', compact('lessonPlan'));
    }

    public function edit(LessonPlan $lessonPlan)
{
    if ($lessonPlan->user_id !== Auth::id()) {
        abort(403);
    }

    // Cari ATP yang menjadi sumber Modul Ajar ini
    // Asumsi: kita cari ATP pertama yang cocok dengan mapel dan kelas
    $teachingFlow = TeachingFlow::where('user_id', Auth::id())
        ->where('subject_id', $lessonPlan->subject_id)
        ->where('grade_level_id', $lessonPlan->grade_level_id)
        ->with('learningObjectives') // Ambil semua TP dari ATP tersebut
        ->firstOrFail(); // Gagal jika tidak ada ATP yang cocok

    // Ambil ID dari TP yang sudah terpilih di Modul Ajar ini
    $selectedObjectives = $lessonPlan->learningObjectives()->pluck('learning_objectives.id')->toArray();

    return view('guru.lesson_plans.edit', compact('lessonPlan', 'teachingFlow', 'selectedObjectives'));
}

    public function update(Request $request, LessonPlan $lessonPlan)
{
    if ($lessonPlan->user_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'duration_in_minutes' => 'nullable|integer',
        'meaningful_understanding' => 'nullable|string',
        'essential_questions' => 'nullable|string',
        'learning_activities' => 'nullable|array',
        'assessment' => 'nullable|array',
        'student_worksheet' => 'nullable|string',
        'reading_materials' => 'nullable|string',
        'learning_objective_ids' => 'required|array|min:1',
        'learning_objective_ids.*' => 'exists:learning_objectives,id',
    ]);

    DB::transaction(function () use ($validated, $lessonPlan) {
        // Update data di tabel lesson_plans
        $lessonPlan->update([
            'title' => $validated['title'],
            'duration_in_minutes' => $validated['duration_in_minutes'],
            'meaningful_understanding' => $validated['meaningful_understanding'],
            'essential_questions' => $validated['essential_questions'],
            'learning_activities' => $validated['learning_activities'],
            'assessment' => $validated['assessment'],
            'student_worksheet' => $validated['student_worksheet'],
            'reading_materials' => $validated['reading_materials'],
        ]);

        // Sinkronkan relasi TP. `sync` akan otomatis menambah/menghapus relasi.
        $lessonPlan->learningObjectives()->sync($validated['learning_objective_ids']);
    });

    return redirect()->route('teacher.lesson-plans.show', $lessonPlan)->with('success', 'Modul Ajar berhasil diperbarui!');
}

    public function destroy(LessonPlan $lessonPlan)
{
    if ($lessonPlan->user_id !== Auth::id()) {
        abort(403);
    }
    $lessonPlan->delete();
    return redirect()->route('teacher.lesson-plans.index')->with('success', 'Modul Ajar berhasil dihapus.');
}


    /**
     * Menghasilkan konten untuk bagian tertentu dari Modul Ajar menggunakan AI.
     */
    public function generateAiSection(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string|in:pedagogical_practices,memahami,mengaplikasi,merefleksi,assessment_formatif,assessment_sumatif',
            'objectives' => 'required|string', // Deskripsi TP yang sudah digabung
            'subject' => 'required|string',
            'grade_level' => 'required|string',
        ]);

        $section = $validated['section'];
        $objectivesText = $validated['objectives'];
        $subject = $validated['subject'];
        $gradeLevel = $validated['grade_level'];
        $basePrompt = "Anda adalah seorang ahli perancang kurikulum dan pakar pedagogi Kurikulum Merdeka. Berdasarkan informasi berikut:\n- Mata Pelajaran: $subject\n- Tingkat Kelas: $gradeLevel\n- Tujuan Pembelajaran (TP) yang ingin dicapai:\n$objectivesText\n\n";
        $specificInstruction = "";

        switch ($section) {
            case 'pedagogical_practices':
                $specificInstruction = "Berikan 1-2 rekomendasi Praktik Pedagogis (seperti pembelajaran berbasis proyek, masalah, atau inkuiri) yang paling sesuai untuk mencapai TP di atas. Jelaskan secara singkat mengapa strategi tersebut cocok.";
                break;
            case 'memahami':
                $specificInstruction = "Rancanglah 2-3 langkah kegiatan konkret untuk pengalaman belajar 'Memahami'. Pastikan kegiatan ini membantu siswa mengonstruksi pengetahuan awal secara aktif sesuai prinsip pembelajaran yang bermakna dan menggembirakan.";
                break;
            case 'mengaplikasi':
                $specificInstruction = "Rancanglah 2-3 langkah kegiatan konkret untuk pengalaman belajar 'Mengaplikasi'. Fokus pada bagaimana siswa dapat menggunakan pengetahuannya dalam konteks kehidupan nyata atau untuk memecahkan masalah.";
                break;
            case 'merefleksi':
                $specificInstruction = "Rancanglah 2-3 langkah kegiatan konkret untuk pengalaman belajar 'Merefleksi'. Kegiatan harus mendorong siswa untuk mengevaluasi proses dan hasil belajar mereka, serta mengembangkan keterampilan regulasi diri.";
                break;
            case 'assessment_formatif':
                $specificInstruction = "Berikan 2-3 ide Asesmen Formatif (penilaian selama proses pembelajaran) yang bisa digunakan untuk memantau kemajuan siswa terhadap TP di atas. Contoh: pertanyaan lisan, observasi, atau kuis singkat.";
                break;
            case 'assessment_sumatif':
                $specificInstruction = "Berikan 1-2 ide Asesmen Sumatif (penilaian di akhir pembelajaran) yang relevan untuk mengukur ketercapaian TP di atas. Contoh: tes tulis, presentasi proyek, atau pembuatan produk.";
                break;
        }

        $prompt = $basePrompt . "Tugas Anda: " . $specificInstruction . "\n\nBerikan jawaban Anda dalam format teks biasa yang siap pakai, tanpa judul atau pembuka tambahan.";

        // Panggilan ke Gemini API
        $apiKey = "AIzaSyDHzZgjbAUhYTlqxucYPtqUFDvM_ep9xBM"; // <-- GANTI DENGAN KUNCI API GEMINI ANDA
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=" . $apiKey;
        $payload = ['contents' => [['parts' => [['text' => $prompt]]]]];

        try {
            $response = Http::post($apiUrl, $payload);
            if ($response->successful()) {
                $generatedText = $response->json('candidates.0.content.parts.0.text');
                return response()->json(['text' => $generatedText]);
            } else {
                return response()->json(['error' => 'Gagal menghubungi AI Service.'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan halaman versi cetak dari Modul Ajar.
     */
    public function printView(LessonPlan $lessonPlan)
    {
        if ($lessonPlan->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
            abort(403);
        }
        
        $lessonPlan->load(['user', 'subject', 'gradeLevel.phase', 'learningObjectives']);
        
        $qrCode = null;
        if ($lessonPlan->status == 'Disetujui') {
            $validationInfo = "Dokumen Modul Ajar '{$lessonPlan->title}' telah divalidasi pada " . \Carbon\Carbon::parse($lessonPlan->validated_at)->isoFormat('D MMMM YYYY');
            $qrCode = QrCode::size(80)->generate($validationInfo);
        }

        return view('guru.lesson_plans.pdf', compact('lessonPlan', 'qrCode'));
    }

    /**
     * Mengunduh Modul Ajar sebagai file PDF.
     */
    public function downloadPdf(LessonPlan $lessonPlan)
    {
        if ($lessonPlan->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
            abort(403);
        }

        $lessonPlan->load(['user', 'subject', 'gradeLevel.phase', 'learningObjectives']);
        
        $qrCode = null;
        if ($lessonPlan->status == 'Disetujui') {
            $validationInfo = "Dokumen Modul Ajar '{$lessonPlan->title}' telah divalidasi pada " . \Carbon\Carbon::parse($lessonPlan->validated_at)->isoFormat('D MMMM YYYY');
            $qrCode = QrCode::size(80)->generate($validationInfo);
        }
        
        $pdf = \PDF::loadView('guru.lesson_plans.pdf', compact('lessonPlan', 'qrCode'));
        $fileName = 'Modul Ajar - ' . \Illuminate\Support\Str::slug($lessonPlan->title) . '.pdf';
        
        return $pdf->download($fileName);
    }
}
