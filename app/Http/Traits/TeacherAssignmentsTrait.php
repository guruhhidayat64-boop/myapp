<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait TeacherAssignmentsTrait
{
    /**
     * Mengambil daftar ID Mata Pelajaran dan Tingkat Kelas yang diajar oleh guru.
     */
    public function getTeacherAssignments()
    {
        $teacherId = Auth::id();

        // Ambil semua penugasan untuk guru yang sedang login
        $assignments = DB::table('class_teacher_subject')
            ->join('classes', 'classes.id', '=', 'class_teacher_subject.class_id')
            ->where('class_teacher_subject.user_id', $teacherId)
            ->select('class_teacher_subject.subject_id', 'classes.grade_level_id')
            ->distinct()
            ->get();

        // Ekstrak ID uniknya
        $subjectIds = $assignments->pluck('subject_id')->unique()->toArray();
        $gradeLevelIds = $assignments->pluck('grade_level_id')->unique()->toArray();

        return [
            'subject_ids' => $subjectIds,
            'grade_level_ids' => $gradeLevelIds,
        ];
    }
}