<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    /**
     * Menampilkan dashboard bimbingan wali dengan daftar murid dampingan.
     */
    public function index()
    {
        $mentor = Auth::user();
        $mentorshipGroup = $mentor->mentorshipGroup()->with('students')->first();

        // Jika guru bukan Guru Wali, tolak akses
        if (!$mentorshipGroup) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak ditugaskan sebagai Guru Wali.');
        }

        $students = $mentorshipGroup->students;

        return view('guru.mentorship.index', compact('students', 'mentorshipGroup'));
    }

    /**
     * Menampilkan jurnal perkembangan untuk satu siswa.
     */
    public function showStudentJournal(Student $student)
    {
        // Verifikasi bahwa siswa ini adalah bagian dari kelompok bimbingan guru yang login
        $mentor = Auth::user();
        $mentorshipGroup = $mentor->mentorshipGroup;

        if (!$mentorshipGroup || !$mentorshipGroup->students->contains($student)) {
            abort(403, 'Anda tidak memiliki akses ke jurnal siswa ini.');
        }
        
        // Ambil semua log perkembangan untuk siswa ini
        $student->load('developmentLogs');

        return view('guru.mentorship.show', compact('student'));
    }

    /**
     * Menyimpan entri jurnal perkembangan baru.
     */
    public function storeDevelopmentLog(Request $request, Student $student)
    {
        $request->validate([
            'log_date' => 'required|date',
            'category' => 'required|string|in:Akademik,Kompetensi & Keterampilan,Karakter',
            'content' => 'required|string',
            'follow_up' => 'nullable|string',
        ]);

        DevelopmentLog::create([
            'student_id' => $student->id,
            'user_id' => Auth::id(), // Guru Wali yang membuat log
            'log_date' => $request->log_date,
            'category' => $request->category,
            'content' => $request->content,
            'follow_up' => $request->follow_up,
        ]);

        return redirect()->back()->with('success', 'Catatan perkembangan berhasil ditambahkan.');
    }
}