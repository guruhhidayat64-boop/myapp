<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\LearningObjective;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradebookController extends Controller
{
    public function selectContext()
    {
        $teacherId = Auth::id();
        $assignments = DB::table('class_teacher_subject')
            ->join('classes', 'classes.id', '=', 'class_teacher_subject.class_id')
            ->join('subjects', 'subjects.id', '=', 'class_teacher_subject.subject_id')
            ->where('class_teacher_subject.user_id', $teacherId)
            ->select('classes.id as class_id', 'classes.name as class_name', 'subjects.id as subject_id', 'subjects.name as subject_name')
            ->distinct()->get();
        return view('guru.gradebook.select', compact('assignments'));
    }

    public function index(Classes $class, Subject $subject)
    {
        $this->authorizeAccess($class, $subject);

        $students = $class->students()->orderBy('name')->get();
        
        $assessments = Assessment::where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->with('learningObjectives')
            ->get();

        // Ambil semua nilai dan kelompokkan berdasarkan siswa dan asesmen untuk akses cepat
        $grades = Grade::whereIn('assessment_id', $assessments->pluck('id'))
            ->get()
            ->groupBy('student_id')
            ->map(fn ($item) => $item->keyBy('assessment_id'));

        // Ambil semua TP yang relevan untuk form pembuatan asesmen
        $learningObjectives = LearningObjective::where('user_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->whereHas('gradeLevel', fn($q) => $q->where('id', $class->grade_level_id))
            ->get();

        return view('guru.gradebook.index', compact('class', 'subject', 'students', 'assessments', 'grades', 'learningObjectives'));
    }

    public function storeAssessment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Formatif,Sumatif',
            'assessment_date' => 'nullable|date',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'learning_objective_ids' => 'required|array|min:1',
            'learning_objective_ids.*' => 'exists:learning_objectives,id',
        ]);

        $this->authorizeAccess(Classes::find($validated['class_id']), Subject::find($validated['subject_id']));

        DB::transaction(function () use ($validated) {
            $assessment = Assessment::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'assessment_date' => $validated['assessment_date'],
                'user_id' => Auth::id(),
                'class_id' => $validated['class_id'],
                'subject_id' => $validated['subject_id'],
            ]);
            $assessment->learningObjectives()->attach($validated['learning_objective_ids']);
        });

        return redirect()->back()->with('success', 'Penilaian baru berhasil dibuat.');
    }

    public function storeGrade(Request $request)
    {
        $validated = $request->validate([
            'assessment_id' => 'required|exists:assessments,id',
            'student_id' => 'required|exists:students,id',
            'score' => 'nullable|string|max:255',
        ]);

        // Verifikasi bahwa guru berhak menginput nilai ini
        $assessment = Assessment::find($validated['assessment_id']);
        $this->authorizeAccess($assessment->class, $assessment->subject);

        Grade::updateOrCreate(
            [
                'assessment_id' => $validated['assessment_id'],
                'student_id' => $validated['student_id'],
            ],
            [
                'score' => $validated['score'],
            ]
        );

        return response()->json(['success' => true]);
    }

    // Fungsi helper untuk otorisasi
    private function authorizeAccess(Classes $class, Subject $subject)
    {
        $isAuthorized = DB::table('class_teacher_subject')
            ->where('user_id', Auth::id())
            ->where('class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->exists();

        if (!$isAuthorized && Auth::user()->role !== 'kepala_sekolah') {
            abort(403, 'Anda tidak ditugaskan untuk mengakses buku nilai ini.');
        }
    }
}