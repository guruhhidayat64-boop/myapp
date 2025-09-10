<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat satu user admin
        DB::table('users')->insert([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'role' => 'admin',
            'password' => Hash::make('password'), // passwordnya adalah "password"
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Anda bisa menambahkan user lain di sini jika perlu
        // Contoh membuat user guru
        DB::table('users')->insert([
            'name' => 'Guru Budi',
            'email' => 'guru.budi@sekolah.test',
            'role' => 'guru',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
    'name' => 'Kepala Sekolah',
    'email' => 'kepsek@sekolah.test',
    'role' => 'kepala_sekolah',
    'password' => Hash::make('password'),
    'created_at' => now(),
    'updated_at' => now(),
]);
    }
}
