<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('gradeLevel')->latest()->paginate(15);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $gradeLevels = GradeLevel::all();
        return view('admin.classes.create', compact('gradeLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level_id' => 'required|exists:grade_levels,id',
        ]);

        Classes::create($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    public function edit(Classes $class)
    {
        $gradeLevels = GradeLevel::all();
        return view('admin.classes.edit', compact('class', 'gradeLevels'));
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level_id' => 'required|exists:grade_levels,id',
        ]);

        $class->update($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
