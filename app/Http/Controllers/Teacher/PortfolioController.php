<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    /**
     * Menampilkan halaman portofolio digital untuk satu siswa.
     */
    public function show(Student $student)
    {
        // Otorisasi: Pastikan guru yang mengakses berhak melihat data siswa ini.
        // Untuk saat ini, kita izinkan semua guru dan kepsek.
        // Nanti bisa diperketat (misal: hanya guru yang mengajar siswa tsb).

        // Ambil semua nilai siswa, beserta relasi ke asesmen dan mata pelajarannya.
        $grades = Grade::where('student_id', $student->id)
            ->with(['assessment.subject', 'assessment.learningObjectives'])
            ->get();

        // Kelompokkan nilai berdasarkan mata pelajaran
        $gradesBySubject = $grades->groupBy('assessment.subject.name');

        return view('guru.portfolio.show', compact('student', 'gradesBySubject'));
    }
}