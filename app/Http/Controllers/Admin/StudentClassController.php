<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classes::orderBy('name')->get();
        $selectedClass = null;
        $studentsInClass = collect();
        $studentsNotInClass = collect();

        // Ambil tahun ajaran saat ini atau dari input
        $academicYear = $request->input('academic_year', date('Y') . '/' . (date('Y') + 1));

        if ($request->filled('class_id')) {
            $selectedClass = Classes::with('students')->findOrFail($request->class_id);

            // Ambil siswa yang ada di kelas ini PADA TAHUN AJARAN INI
            $studentsInClass = $selectedClass->students()
                ->wherePivot('academic_year', $academicYear)
                ->get();

            // Ambil ID siswa yang sudah ada di kelas ini
            $studentIdsInClass = $studentsInClass->pluck('id');

            // Ambil siswa yang BELUM punya kelas PADA TAHUN AJARAN INI
            $studentsNotInClass = Student::whereDoesntHave('classes', function ($query) use ($academicYear) {
                $query->where('class_student.academic_year', $academicYear);
            })->orWhereNotIn('id', $studentIdsInClass)->get();
        }

        return view('admin.student_classes.index', compact(
            'classes',
            'selectedClass',
            'studentsInClass',
            'studentsNotInClass',
            'academicYear'
        ));
    }

    public function assignStudent(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'academic_year' => 'required|string',
        ]);

        $class = Classes::find($request->class_id);
        
        // Gunakan attach untuk menambahkan relasi di tabel pivot
        $class->students()->attach($request->student_id, [
            'academic_year' => $request->academic_year
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function unassignStudent(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'academic_year' => 'required|string',
        ]);

        $class = Classes::find($request->class_id);

        // Gunakan detach untuk menghapus relasi
        $class->students()->wherePivot('academic_year', $request->academic_year)->detach($request->student_id);

        return redirect()->back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}