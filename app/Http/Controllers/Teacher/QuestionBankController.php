<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\LearningObjective;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionBankController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::where('user_id', Auth::id())->with(['subject', 'gradeLevel']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('grade_level_id')) {
            $query->where('grade_level_id', $request->grade_level_id);
        }

        $questions = $query->latest()->paginate(15);
        $subjects = Subject::orderBy('name')->get();
        $gradeLevels = GradeLevel::all();

        return view('guru.question_bank.index', compact('questions', 'subjects', 'gradeLevels'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        $gradeLevels = GradeLevel::all();
        // Ambil semua TP milik guru untuk pilihan awal
        $learningObjectives = LearningObjective::where('user_id', Auth::id())->get();

        return view('guru.question_bank.create', compact('subjects', 'gradeLevels', 'learningObjectives'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'grade_level_id' => 'required|exists:grade_levels,id',
            'type' => 'required|in:Pilihan Ganda,Esai',
            'question_text' => 'required|string',
            'options' => 'required_if:type,Pilihan Ganda|array',
            'options.a' => 'required_if:type,Pilihan Ganda|string',
            'options.b' => 'required_if:type,Pilihan Ganda|string',
            'options.c' => 'required_if:type,Pilihan Ganda|string',
            'options.d' => 'required_if:type,Pilihan Ganda|string',
            'answer_key' => 'required|string',
            'learning_objective_ids' => 'required|array|min:1',
            'learning_objective_ids.*' => 'exists:learning_objectives,id',
        ]);

        DB::transaction(function () use ($validated) {
            $question = Question::create([
                'user_id' => Auth::id(),
                'subject_id' => $validated['subject_id'],
                'grade_level_id' => $validated['grade_level_id'],
                'type' => $validated['type'],
                'question_text' => $validated['question_text'],
                'options' => $validated['type'] == 'Pilihan Ganda' ? $validated['options'] : null,
                'answer_key' => $validated['answer_key'],
            ]);

            $question->learningObjectives()->attach($validated['learning_objective_ids']);
        });

        return redirect()->route('teacher.question-bank.index')->with('success', 'Soal baru berhasil ditambahkan ke bank soal.');
    }

    // Method edit, update, destroy akan kita tambahkan nanti jika diperlukan
}
