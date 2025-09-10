<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\Phase; // <-- PENTING: Import model Phase
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data tingkat kelas bersama dengan relasi fasenya
        $gradeLevels = GradeLevel::with('phase')->latest()->paginate(10);
        return view('admin.grade_levels.index', compact('gradeLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data fase untuk ditampilkan di dropdown
        $phases = Phase::all();
        return view('admin.grade_levels.create', compact('phases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phase_id' => 'required|exists:phases,id', // Validasi bahwa phase_id ada di tabel phases
        ]);

        GradeLevel::create($request->all());

        return redirect()->route('admin.grade-levels.index')->with('success', 'Tingkat Kelas berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeLevel $gradeLevel)
    {
        $phases = Phase::all();
        return view('admin.grade_levels.edit', compact('gradeLevel', 'phases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GradeLevel $gradeLevel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phase_id' => 'required|exists:phases,id',
        ]);

        $gradeLevel->update($request->all());

        return redirect()->route('admin.grade-levels.index')->with('success', 'Tingkat Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GradeLevel $gradeLevel)
    {
        $gradeLevel->delete();
        return redirect()->route('admin.grade-levels.index')->with('success', 'Tingkat Kelas berhasil dihapus.');
    }
}
