<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\CalendarEvent;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TeachingFlow;

class StudentController extends Controller // Nama class diubah
{
    public function index() // Method dashboard tetap ada
    {
        $student = Auth::user()->studentProfile;
        if (!$student) {
            Auth::logout();
            return redirect('/login')->with('error', 'Profil siswa tidak ditemukan.');
        }

        $upcomingAssessments = Assessment::whereHas('class.students', fn($q) => $q->where('students.id', $student->id))
            ->where('assessment_date', '>=', Carbon::today())
            ->where('assessment_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('assessment_date', 'asc')->with('subject')->take(5)->get();

        $recentGrades = Grade::where('student_id', $student->id)
            ->with('assessment.subject')->latest()->take(5)->get();
        
        $schoolEvents = CalendarEvent::whereNull('user_id')
            ->where('start', '>=', Carbon::today())
            ->orderBy('start', 'asc')->take(3)->get();

        return view('siswa.dashboard', compact('upcomingAssessments', 'recentGrades', 'schoolEvents'));
    }

    /**
     * Menampilkan halaman portofolio nilai untuk siswa yang login.
     */
    public function portfolio()
    {
        $student = Auth::user()->studentProfile;

        $grades = Grade::where('student_id', $student->id)
            ->with(['assessment.subject', 'assessment.learningObjectives'])
            ->get();

        $gradesBySubject = $grades->groupBy('assessment.subject.name');

        return view('siswa.portfolio', compact('student', 'gradesBySubject'));
    }

    /**
     * Menampilkan halaman Peta Belajar (visualisasi ATP) untuk siswa.
     */
    public function learningMap()
    {
        $student = Auth::user()->studentProfile;
        if (!$student) {
            abort(404, 'Profil siswa tidak ditemukan.');
        }

        // Asumsi: Ambil tahun ajaran saat ini. Ini bisa dibuat lebih dinamis nanti.
        $currentAcademicYear = date('Y') . '/' . (date('Y') + 1);

        // 1. Cari kelas siswa di tahun ajaran ini
        $currentClass = $student->classes()->where('academic_year', $currentAcademicYear)->first();

        if (!$currentClass) {
            return view('siswa.learning_map', ['teachingFlows' => collect()]);
        }

        // 2. Cari semua mata pelajaran yang diajarkan di kelas tersebut
        $subjectIds = DB::table('class_teacher_subject')
            ->where('class_id', $currentClass->id)
            ->pluck('subject_id')
            ->unique();

        // 3. Cari semua ATP yang cocok dengan tingkat kelas dan mata pelajaran siswa
        $teachingFlows = TeachingFlow::where('grade_level_id', $currentClass->grade_level_id)
            ->whereIn('subject_id', $subjectIds)
            ->with(['subject', 'learningObjectives']) // Eager load relasi penting
            ->get();

        // 4. Ambil semua TP yang sudah pernah dinilai untuk siswa ini
        $assessedTpIds = Grade::where('student_id', $student->id)
            ->with('assessment.learningObjectives')
            ->get()
            ->pluck('assessment.learningObjectives')
            ->flatten()
            ->pluck('id')
            ->unique();

        return view('siswa.learning_map', compact('teachingFlows', 'assessedTpIds'));
    }
}