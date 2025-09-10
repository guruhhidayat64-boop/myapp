<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningOutcome;
use App\Models\Phase;
use App\Models\Subject;
use App\Models\Element;
use Illuminate\Http\Request;

class LearningOutcomeController extends Controller
{
    public function index()
    {
        $outcomes = LearningOutcome::with(['phase', 'subject', 'element'])->latest()->paginate(10);
        return view('admin.learning_outcomes.index', compact('outcomes'));
    }

    public function create()
    {
        $phases = Phase::all();
        $subjects = Subject::all();
        $elements = Element::all();
        return view('admin.learning_outcomes.create', compact('phases', 'subjects', 'elements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phase_id' => 'required|exists:phases,id',
            'subject_id' => 'required|exists:subjects,id',
            'element_id' => 'required|exists:elements,id',
            'description' => 'required|string',
        ]);

        LearningOutcome::create($request->all());
        return redirect()->route('admin.learning-outcomes.index')->with('success', 'Capaian Pembelajaran berhasil ditambahkan.');
    }

    public function edit(LearningOutcome $learningOutcome)
    {
        $phases = Phase::all();
        $subjects = Subject::all();
        $elements = Element::all();
        return view('admin.learning_outcomes.edit', compact('learningOutcome', 'phases', 'subjects', 'elements'));
    }

    public function update(Request $request, LearningOutcome $learningOutcome)
    {
        $request->validate([
            'phase_id' => 'required|exists:phases,id',
            'subject_id' => 'required|exists:subjects,id',
            'element_id' => 'required|exists:elements,id',
            'description' => 'required|string',
        ]);

        $learningOutcome->update($request->all());
        return redirect()->route('admin.learning-outcomes.index')->with('success', 'Capaian Pembelajaran berhasil diperbarui.');
    }

    public function destroy(LearningOutcome $learningOutcome)
    {
        $learningOutcome->delete();
        return redirect()->route('admin.learning-outcomes.index')->with('success', 'Capaian Pembelajaran berhasil dihapus.');
    }
}