<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\LearningObjective;
use App\Models\TeachingFlow;
use App\Models\LessonPlan;
use App\Models\Kktp;
use App\Models\Subject;
use App\Models\LearningOutcome;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $hour = Carbon::now()->hour;
        $greeting = "Selamat Datang";
        if ($hour < 11) $greeting = "Selamat Pagi";
        elseif ($hour < 15) $greeting = "Selamat Siang";
        elseif ($hour < 19) $greeting = "Selamat Sore";
        else $greeting = "Selamat Malam";

        if ($role == 'admin') {
            $userCount = User::count();
            $teacherCount = User::where('role', 'guru')->count();
            $subjectCount = Subject::count();
            $cpCount = LearningOutcome::count();
            $recentUsers = User::latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'greeting',
                'userCount',
                'teacherCount',
                'subjectCount',
                'cpCount',
                'recentUsers'
            ));
        } elseif ($role == 'guru') {
            $tpCount = LearningObjective::where('user_id', $user->id)->count();
            $atpCount = TeachingFlow::where('user_id', $user->id)->count();
            $rpCount = LessonPlan::where('user_id', $user->id)->count();
            $flowsForRevision = TeachingFlow::where('user_id', $user->id)
                ->where('status', 'Perlu Revisi')
                ->with('subject', 'gradeLevel')
                ->get();
            return view('guru.dashboard', compact('greeting', 'tpCount', 'atpCount', 'rpCount', 'flowsForRevision'));
        } elseif ($role == 'kepala_sekolah') {
            $teacherCount = User::where('role', 'guru')->count();
            $atpCount = TeachingFlow::count();
            $rpCount = LessonPlan::count();
            $totalTp = LearningObjective::count();
            $tpWithKktp = Kktp::count();
            $kktpPercentage = ($totalTp > 0) ? round(($tpWithKktp / $totalTp) * 100) : 0;
            return view('kepala_sekolah.dashboard', compact('greeting', 'teacherCount', 'atpCount', 'rpCount', 'kktpPercentage'));
        
        // ==================== PERBAIKAN DI SINI ====================
        // Memindahkan blok 'siswa' ke dalam rantai if-elseif utama
        // ==========================================================
        } elseif ($role == 'siswa') {
            return redirect()->route('student.dashboard');
        }

        return view('dashboard');
    }
}
