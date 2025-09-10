<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeroomController extends Controller {
        /**
         * Menampilkan halaman kelas perwalian.
         */
    public function index()
        {
            $user = Auth::user();
            
            // Ambil data kelas perwalian beserta daftar siswanya
            $homeroomClass = $user->homeroomClass()->with('students')->first();

            // Jika guru bukan wali kelas, tolak akses
            if (!$homeroomClass) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak ditugaskan sebagai Wali Kelas.');
            }

            return view('guru.homeroom.index', compact('homeroomClass'));
        }

    /**
     * Menampilkan halaman versi cetak dari daftar hadir kelas.
     */
    public function printAttendance()
    {
        $user = Auth::user();
        $homeroomClass = $user->homeroomClass()->with('students')->first();

        if (!$homeroomClass) {
            abort(403, 'Anda bukan Wali Kelas.');
        }

        // Ambil data profil sekolah untuk kop surat
        $schoolProfile = \App\Models\Setting::pluck('value', 'key')->all();

        // Data untuk bulan dan tahun saat ini
        $month = \Carbon\Carbon::now()->isoFormat('MMMM');
        $year = \Carbon\Carbon::now()->year;
        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;

        return view('guru.homeroom.attendance_pdf', compact(
            'homeroomClass', 
            'schoolProfile', 
            'month', 
            'year',
            'daysInMonth'
        ));
    }    
}
    