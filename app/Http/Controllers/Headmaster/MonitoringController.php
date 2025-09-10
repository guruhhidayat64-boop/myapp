<?php

namespace App\Http\Controllers\Headmaster;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\LessonPlan;
use App\Models\Subject;
use App\Models\TeachingFlow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PERBAIKAN UTAMA DI SINI

class MonitoringController extends Controller
{
    public function monitorAtp(Request $request)
    {
        $query = TeachingFlow::with(['user', 'subject', 'gradeLevel']);
        if ($request->filled('teacher_id')) {
            $query->where('user_id', $request->teacher_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('grade_level_id')) {
            $query->where('grade_level_id', $request->grade_level_id);
        }
        $teachingFlows = $query->latest()->paginate(15);
        $teachers = User::where('role', 'guru')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $gradeLevels = GradeLevel::all();
        return view('kepala_sekolah.monitoring.atp', compact('teachingFlows', 'teachers', 'subjects', 'gradeLevels'));
    }

    public function monitorLessonPlans(Request $request)
    {
        $query = LessonPlan::with(['user', 'subject', 'gradeLevel']);
        if ($request->filled('teacher_id')) {
            $query->where('user_id', $request->teacher_id);
        }
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('grade_level_id')) {
            $query->where('grade_level_id', $request->grade_level_id);
        }
        $lessonPlans = $query->latest()->paginate(15);
        $teachers = User::where('role', 'guru')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $gradeLevels = GradeLevel::all();
        return view('kepala_sekolah.monitoring.lesson_plans', compact('lessonPlans', 'teachers', 'subjects', 'gradeLevels'));
    }

    public function validateAtp(Request $request, TeachingFlow $teaching_flow)
    {
        $request->validate([
            'status' => 'required|string|in:Menunggu Tinjauan,Disetujui,Perlu Revisi',
            'feedback' => 'nullable|string',
        ]);

        $teaching_flow->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->route('headmaster.monitoring.atp')->with('success', 'Umpan balik untuk ATP berhasil disimpan.');
    }

    /**
     * Menyimpan hasil validasi dan umpan balik untuk sebuah Modul Ajar.
     */
    public function validateLessonPlan(Request $request, LessonPlan $lesson_plan)
    {
        $request->validate([
            'status' => 'required|string|in:Menunggu Tinjauan,Disetujui,Perlu Revisi',
            'feedback' => 'nullable|string',
        ]);

        $lesson_plan->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()->route('headmaster.monitoring.lessonPlans')->with('success', 'Umpan balik untuk Modul Ajar berhasil disimpan.');
    }
}
