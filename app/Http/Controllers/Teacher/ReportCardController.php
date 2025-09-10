<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ReportCardController extends Controller
{
    /**
     * Menampilkan halaman pemilihan siswa untuk Wali Kelas.
     */
    public function index()
    {
        $homeroomClass = Auth::user()->homeroomClass()->with('students')->first();
        if (!$homeroomClass) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak ditugaskan sebagai Wali Kelas.');
        }
        return view('guru.report_cards.index', compact('homeroomClass'));
    }

    /**
     * Menampilkan halaman generator rapor untuk satu siswa.
     */
    public function show(Student $student)
    {
        $homeroomClass = Auth::user()->homeroomClass;
        if (!$homeroomClass || !$homeroomClass->students->contains($student)) {
            abort(403, 'Siswa ini bukan bagian dari kelas perwalian Anda.');
        }

        $grades = Grade::where('student_id', $student->id)
            ->with(['assessment.subject', 'assessment.learningObjectives'])
            ->get();
        $gradesBySubject = $grades->groupBy('assessment.subject.name');

        return view('guru.report_cards.show', compact('student', 'gradesBySubject'));
    }

    /**
     * Menggunakan AI untuk menghasilkan narasi rapor.
     */
    public function generateNarrative(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'grades_summary' => 'required|string',
        ]);

        $subject = $request->subject;
        $summary = $request->grades_summary;

        $prompt = "Anda adalah seorang Wali Kelas yang bijaksana dan berpengalaman. Berdasarkan rekapitulasi pencapaian kompetensi seorang siswa dalam mata pelajaran $subject berikut ini, tulislah sebuah narasi deskriptif untuk rapor.
        
        Gunakan bahasa yang positif, konstruktif, dan mudah dipahami oleh orang tua. Soroti kompetensi yang sudah dikuasai dengan baik dan sebutkan area yang masih perlu ditingkatkan dengan kalimat yang memotivasi.
        
        Data Pencapaian Siswa:
        $summary

        Tolong berikan hasilnya dalam satu paragraf naratif yang utuh.";

        $apiKey = "AIzaSyDHzZgjbAUhYTlqxucYPtqUFDvM_ep9xBM"; // <-- GANTI DENGAN KUNCI API GEMINI ANDA
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-05-20:generateContent?key=" . $apiKey;
        $payload = ['contents' => [['parts' => [['text' => $prompt]]]]];

        try {
            $response = Http::post($apiUrl, $payload);
            if ($response->successful()) {
                $generatedText = $response->json('candidates.0.content.parts.0.text');
                return response()->json(['narrative' => $generatedText]);
            } else {
                return response()->json(['error' => 'Gagal menghubungi AI Service.'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}