<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\Subject; // <-- PENTING
use Illuminate\Http\Request;

class ElementController extends Controller
{
    public function index()
    {
        $elements = Element::with('subject')->latest()->paginate(10);
        return view('admin.elements.index', compact('elements'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.elements.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        Element::create($request->all());
        return redirect()->route('admin.elements.index')->with('success', 'Elemen berhasil ditambahkan.');
    }

    public function edit(Element $element)
    {
        $subjects = Subject::all();
        return view('admin.elements.edit', compact('element', 'subjects'));
    }

    public function update(Request $request, Element $element)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $element->update($request->all());
        return redirect()->route('admin.elements.index')->with('success', 'Elemen berhasil diperbarui.');
    }

    public function destroy(Element $element)
    {
        $element->delete();
        return redirect()->route('admin.elements.index')->with('success', 'Elemen berhasil dihapus.');
    }
}
