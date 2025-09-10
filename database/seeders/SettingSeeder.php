<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kunci-kunci pengaturan untuk profil sekolah
        $settings = [
            ['key' => 'school_name', 'value' => 'Nama Sekolah Anda'],
            ['key' => 'school_npsn', 'value' => '12345678'],
            ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 1, Kota Ilmu'],
            ['key' => 'school_phone', 'value' => '021-1234567'],
            ['key' => 'school_email', 'value' => 'info@sekolah.sch.id'],
            ['key' => 'school_headmaster', 'value' => 'Nama Kepala Sekolah'],
            ['key' => 'school_vision', 'value' => 'Menjadi institusi pendidikan terdepan yang berkarakter dan berwawasan global.'],
            ['key' => 'school_mission', 'value' => '1. Menyelenggarakan pendidikan berkualitas.\n2. Mengembangkan potensi siswa secara optimal.\n3. Membentuk karakter siswa yang berakhlak mulia.'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}