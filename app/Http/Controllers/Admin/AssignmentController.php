<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'guru')->orderBy('name')->get();
        $classes = Classes::with('homeroomTeacher')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        // Menggunakan nama tabel dan kolom yang benar
        $teachingAssignments = DB::table('class_teacher_subject')
            ->join('users', 'users.id', '=', 'class_teacher_subject.user_id')
            ->join('subjects', 'subjects.id', '=', 'class_teacher_subject.subject_id')
            ->join('classes', 'classes.id', '=', 'class_teacher_subject.class_id')
            ->select('users.id as user_id', 'users.name as teacher_name', 'subjects.id as subject_id', 'subjects.name as subject_name', 'classes.id as class_id', 'classes.name as class_name')
            ->get()
            ->groupBy('teacher_name');

        return view('admin.assignments.index', compact('teachers', 'classes', 'subjects', 'teachingAssignments'));
    }

    public function storeHomeroom(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $class = Classes::find($request->class_id);
        $class->homeroom_teacher_id = $request->teacher_id;
        $class->save();

        return redirect()->route('admin.assignments.index')->with('success', 'Wali Kelas berhasil ditetapkan.');
    }

    public function storeTeaching(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
        ]);

        $teacher = User::find($request->teacher_id);
        foreach ($request->class_ids as $classId) {
            // Menggunakan nama tabel dan kolom yang benar
            $exists = DB::table('class_teacher_subject')
                ->where('user_id', $teacher->id)
                ->where('subject_id', $request->subject_id)
                ->where('class_id', $classId)
                ->exists();

            if (!$exists) {
                DB::table('class_teacher_subject')->insert([
                    'user_id' => $teacher->id,
                    'subject_id' => $request->subject_id,
                    'class_id' => $classId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.assignments.index')->with('success', 'Penugasan mengajar berhasil ditambahkan.');
    }

    public function destroyTeaching($userId, $subjectId, $classId)
    {
        // Menggunakan nama tabel dan kolom yang benar
        DB::table('class_teacher_subject')
            ->where('user_id', $userId)
            ->where('subject_id', $subjectId)
            ->where('class_id', $classId)
            ->delete();
        
        return redirect()->route('admin.assignments.index')->with('success', 'Penugasan mengajar berhasil dihapus.');
    }
}
