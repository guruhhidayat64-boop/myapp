<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Kktp;
use App\Models\LearningObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KktpController extends Controller
{
    public function index(LearningObjective $learningObjective)
    {
        if ($learningObjective->user_id !== Auth::id()) {
            abort(403);
        }
        // Memuat KKTP yang sudah ada, atau membuat objek baru jika belum ada
        $kktp = $learningObjective->kktp ?? new Kktp();

        return view('guru.kktp.index', compact('learningObjective', 'kktp'));
    }

    public function store(Request $request, LearningObjective $learningObjective)
    {
        if ($learningObjective->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'type' => 'required|in:deskripsi,rubrik,skala',
            'content' => 'required|array'
        ]);

        // Gunakan updateOrCreate untuk membuat atau memperbarui KKTP
        Kktp::updateOrCreate(
            ['learning_objective_id' => $learningObjective->id],
            [
                'type' => $request->type,
                'content' => $request->content,
            ]
        );

        return redirect()->back()->with('success', 'KKTP berhasil disimpan.');
    }
}
