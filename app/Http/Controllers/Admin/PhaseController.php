<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Phase; // Pastikan ini ada
use Illuminate\Http\Request;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phases = Phase::latest()->paginate(10);
        return view('admin.phases.index', compact('phases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.phases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:phases',
            'description' => 'nullable|string',
        ]);

        Phase::create($request->all());

        return redirect()->route('admin.phases.index')->with('success', 'Fase berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        return view('admin.phases.edit', compact('phase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Phase $phase)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:phases,name,'.$phase->id,
            'description' => 'nullable|string',
        ]);

        $phase->update($request->all());

        return redirect()->route('admin.phases.index')->with('success', 'Fase berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        $phase->delete();
        return redirect()->route('admin.phases.index')->with('success', 'Fase berhasil dihapus.');
    }
}
