<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\LearningObjective;
use App\Models\TeachingFlow;
use App\Models\Subject;
use App\Models\GradeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF; // <-- Pastikan ini ada

class TeachingFlowController extends Controller
{
    public function index()
    {
        $teachingFlows = TeachingFlow::where('user_id', Auth::id())
            ->with(['subject', 'gradeLevel'])
            ->latest()
            ->paginate(10);

        return view('guru.teaching_flows.index', compact('teachingFlows'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();
        return view('guru.teaching_flows.create', compact('subjects', 'gradeLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'description' => 'nullable|string',
        ]);

        $teachingFlow = TeachingFlow::create($request->all() + ['user_id' => Auth::id()]);

        return redirect()->route('teacher.teaching-flows.edit', $teachingFlow)->with('success', 'Wadah ATP berhasil dibuat. Sekarang, silakan susun alurnya.');
    }

    public function edit(TeachingFlow $teachingFlow)
{
    // Izinkan akses jika pengguna adalah pemilik ATAU seorang kepala sekolah
    if ($teachingFlow->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
        abort(403, 'AKSES DITOLAK');
    }
    
    // Ambil TP yang sudah ada di dalam alur ini
    $flowObjectives = $teachingFlow->learningObjectives()->get();
    $flowObjectiveIds = $flowObjectives->pluck('id')->toArray();

    // ==================== PERBAIKAN DI SINI ====================
    // Ambil TP yang tersedia (Bank TP) milik guru yang membuat ATP, bukan milik user yang sedang login
    $availableObjectives = LearningObjective::where('user_id', $teachingFlow->user_id)
        ->where('subject_id', $teachingFlow->subject_id)
        ->where('grade_level_id', $teachingFlow->grade_level_id)
        ->whereNotIn('id', $flowObjectiveIds)
        ->get();
    // ==========================================================

    return view('guru.teaching_flows.edit', compact('teachingFlow', 'flowObjectives', 'availableObjectives'));
}


    public function update(Request $request, TeachingFlow $teachingFlow)
    {
        if ($teachingFlow->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate([
            'objectives' => 'nullable|array',
            'objectives.*.id' => 'required|exists:learning_objectives,id',
            'objectives.*.order' => 'required|integer',
            'objectives.*.estimated_hours' => 'nullable|integer',
            'objectives.*.notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $teachingFlow) {
            $teachingFlow->learningObjectives()->detach();

            if ($request->has('objectives')) {
                foreach ($request->objectives as $objectiveData) {
                    $teachingFlow->learningObjectives()->attach($objectiveData['id'], [
                        'order' => $objectiveData['order'],
                        'estimated_hours' => $objectiveData['estimated_hours'],
                        'notes' => $objectiveData['notes'],
                    ]);
                }
            }
        });

        return redirect()->route('teacher.teaching-flows.index')->with('success', 'Alur Tujuan Pembelajaran berhasil disimpan!');
    }

    public function destroy(TeachingFlow $teachingFlow)
    {
        if ($teachingFlow->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        
        $teachingFlow->delete();
        return redirect()->route('teacher.teaching-flows.index')->with('success', 'ATP berhasil dihapus.');
    }

    /**
     * Mengunduh ATP sebagai file PDF.
     */
    public function downloadPdf(TeachingFlow $teachingFlow)
    {
        if ($teachingFlow->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
            abort(403);
        }

        $flow = $teachingFlow->load('learningObjectives.element', 'subject', 'gradeLevel');
        
        $qrCode = null;
        // Hanya generate QR Code jika statusnya 'Disetujui'
        if ($flow->status == 'Disetujui') {
            // Konten QR Code bisa berupa teks sederhana atau URL
            $validationInfo = "Dokumen ATP '{$flow->name}' telah divalidasi pada " . \Carbon\Carbon::parse($flow->validated_at)->isoFormat('D MMMM YYYY');
            $qrCode = QrCode::size(80)->generate($validationInfo);
        }
        
        $pdf = \PDF::loadView('guru.teaching_flows.pdf', compact('flow', 'qrCode'));
        $fileName = 'ATP - ' . \Illuminate\Support\Str::slug($flow->name) . '.pdf';
        
        return $pdf->download($fileName);
    }

    /**
     * Menampilkan halaman versi cetak dari ATP.
     */
    public function printView(TeachingFlow $teachingFlow)
    {
        if ($teachingFlow->user_id !== Auth::id() && Auth::user()->role !== 'kepala_sekolah') {
            abort(403);
        }
        
        $flow = $teachingFlow->load('learningObjectives.element', 'subject', 'gradeLevel');
        
        $qrCode = null;
        if ($flow->status == 'Disetujui') {
            $validationInfo = "Dokumen ATP '{$flow->name}' telah divalidasi pada " . \Carbon\Carbon::parse($flow->validated_at)->isoFormat('D MMMM YYYY');
            $qrCode = QrCode::size(80)->generate($validationInfo);
        }

        return view('guru.teaching_flows.pdf', compact('flow', 'qrCode'));
    }

    /**
     * Menggunakan AI untuk mengurutkan daftar TP menjadi sebuah draf ATP.
     */
    public function generateAtpAi(Request $request)
    {
        $validated = $request->validate([
            'objectives' => 'required|array|min:2',
            'objectives.*.id' => 'required|integer',
            'objectives.*.description' => 'required|string',
            'subject' => 'required|string', // Tambahkan validasi untuk konteks
            'grade_level' => 'required|string',
        ]);

        $objectives = $validated['objectives'];
        $subject = $validated['subject'];
        $gradeLevel = $validated['grade_level'];

        $formattedObjectives = "";
        foreach ($objectives as $objective) {
            $formattedObjectives .= "ID: " . $objective['id'] . ", Deskripsi: \"" . $objective['description'] . "\"\n";
        }

        // ==================== PROMPT BARU YANG LEBIH DETAIL ====================
        $prompt = "Anda adalah seorang ahli perancang kurikulum untuk jenjang $gradeLevel mata pelajaran $subject.
        Tugas Anda adalah menyusun daftar Tujuan Pembelajaran (TP) yang tidak berurutan ini menjadi sebuah Alur Tujuan Pembelajaran (ATP) yang logis dan sistematis.

        Untuk setiap TP dalam alur yang Anda susun, berikan juga:
        1.  `estimated_hours`: Perkiraan alokasi waktu dalam Jam Pelajaran (JP). Asumsikan 1 JP = 40 menit. Pertimbangkan kompleksitas materi. Berikan dalam bentuk angka saja.
        2.  `notes`: Satu ide singkat untuk Materi/Aktivitas pembelajaran yang relevan dengan TP tersebut.

        Daftar Tujuan Pembelajaran (TP):
        $formattedObjectives

        Berikan hasilnya HANYA dalam format JSON array objek yang ketat. Setiap objek harus berisi 'id', 'estimated_hours', dan 'notes'.
        Contoh format: {\"sorted_objectives\": [{\"id\": 3, \"estimated_hours\": 4, \"notes\": \"Diskusi kelompok tentang bilangan bulat\"}, {\"id\": 1, \"estimated_hours\": 6, \"notes\": \"Proyek membuat garis bilangan raksasa\"}]}";
        // =======================================================================

        $apiKey = "AIzaSyDHzZgjbAUhYTlqxucYPtqUFDvM_ep9xBM"; // <-- GANTI DENGAN KUNCI API GEMINI ANDA
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=" . $apiKey;
        $payload = ['contents' => [['parts' => [['text' => $prompt]]]]];

        try {
            $response = Http::post($apiUrl, $payload);

            if ($response->successful()) {
                $rawText = $response->json('candidates.0.content.parts.0.text');
                $cleanedJson = trim(str_replace(['```json', '```'], '', $rawText));
                $data = json_decode($cleanedJson, true);

                // Ganti 'sorted_ids' menjadi 'sorted_objectives'
                if (json_last_error() === JSON_ERROR_NONE && isset($data['sorted_objectives'])) {
                    return response()->json($data);
                } else {
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