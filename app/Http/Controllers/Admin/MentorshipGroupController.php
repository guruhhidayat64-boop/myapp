<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorshipGroup;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorshipGroupController extends Controller
{
    public function index(Request $request)
    {
        // Ambil guru yang belum menjadi Guru Wali
        $assignedMentorIds = MentorshipGroup::pluck('user_id');
        $availableTeachers = User::where('role', 'guru')->whereNotIn('id', $assignedMentorIds)->orderBy('name')->get();
        
        $groups = MentorshipGroup::with('mentor')->get();
        $selectedGroup = null;
        $studentsInGroup = collect();
        $studentsNotInGroup = collect();

        if ($request->filled('group_id')) {
            $selectedGroup = MentorshipGroup::with('students')->findOrFail($request->group_id);
            $studentsInGroup = $selectedGroup->students;
            $studentIdsInGroup = $studentsInGroup->pluck('id');

            // Ambil siswa yang belum punya kelompok bimbingan
            $studentsNotInGroup = Student::whereDoesntHave('mentorshipGroup')->whereNotIn('id', $studentIdsInGroup)->get();
        }

        return view('admin.mentorship_groups.index', compact(
            'availableTeachers',
            'groups',
            'selectedGroup',
            'studentsInGroup',
            'studentsNotInGroup'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id|unique:mentorship_groups,user_id',
        ]);

        MentorshipGroup::create($request->all());

        return redirect()->route('admin.mentorship-groups.index')->with('success', 'Kelompok bimbingan baru berhasil dibuat.');
    }

    public function destroy(MentorshipGroup $mentorshipGroup)
    {
        $mentorshipGroup->delete();
        return redirect()->route('admin.mentorship-groups.index')->with('success', 'Kelompok bimbingan berhasil dihapus.');
    }

    public function assignStudent(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:mentorship_groups,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $group = MentorshipGroup::find($request->group_id);
        $group->students()->attach($request->student_id);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kelompok.');
    }

    public function unassignStudent(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:mentorship_groups,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $group = MentorshipGroup::find($request->group_id);
        $group->students()->detach($request->student_id);

        return redirect()->back()->with('success', 'Siswa berhasil dikeluarkan dari kelompok.');
    }
}