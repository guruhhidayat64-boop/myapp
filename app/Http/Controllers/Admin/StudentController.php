<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'nisn' => 'required|string|max:20|unique:students,nisn', // NISN sekarang wajib
        'gender' => 'required|in:Laki-laki,Perempuan',
        'birth_place' => 'nullable|string|max:255',
        'birth_date' => 'nullable|date',
        'address' => 'nullable|string',
        'parent_name' => 'nullable|string|max:255',
        'parent_phone' => 'nullable|string|max:20',
    ]);

    // 1. Buat akun user baru untuk siswa
    $user = User::create([
        'name' => $validated['name'],
        // Email dibuat dari NISN agar unik. Ganti '.school' sesuai domain Anda.
        'email' => $validated['nisn'] . '@sekolah.test', 
        'role' => 'siswa',
        // Password default, siswa bisa mengubahnya nanti
        'password' => Hash::make('password123'), 
    ]);

    // 2. Buat profil siswa dan tautkan dengan user_id yang baru dibuat
    $student = new Student($validated);
    $student->user_id = $user->id;
    $student->save();

    return redirect()->route('admin.students.index')->with('success', 'Data siswa baru berhasil ditambahkan. Akun login telah dibuat secara otomatis.');
}

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20|unique:students,nisn,' . $student->id,
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Menangani proses impor data siswa dari file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return redirect()->back()->with('error', 'Gagal mengimpor data. Periksa kesalahan berikut: <br>' . implode('<br>', $errorMessages));
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor.');
    }

    /**
     * Mengunduh template Excel untuk impor.
     */
    public function downloadTemplate()
    {
        $path = public_path('templates/template_siswa.xlsx');
        return response()->download($path);
    }
}