<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    /**
     * Menampilkan halaman profil sekolah.
     */
    public function index()
    {
        // Ambil semua data setting dan ubah menjadi array asosiatif [key => value]
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.school_profile.index', compact('settings'));
    }

    /**
     * Memperbarui data profil sekolah.
     */
    public function update(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_email' => 'required|email',
            'school_vision' => 'required|string',
            'school_mission' => 'required|string',
        ]);

        // Ambil semua data dari form
        $data = $request->except('_token');

        // Loop dan update setiap setting
        foreach ($data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
