<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\TeachingFlow;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman homepage dengan data statistik.
     */
    public function index()
    {
        // Ambil data statistik untuk ditampilkan di homepage
        $teacherCount = User::where('role', 'guru')->count();
        
        // Hitung total semua perangkat ajar yang telah dibuat
        $atpCount = TeachingFlow::count();
        $rpCount = LessonPlan::count();
        $totalDocuments = $atpCount + $rpCount;

        // Kirim data ke view
        return view('welcome', compact('teacherCount', 'totalDocuments'));
    }
}
