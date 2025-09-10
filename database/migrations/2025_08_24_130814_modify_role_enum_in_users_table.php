<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom 'role' untuk menambahkan 'siswa'
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'kepala_sekolah', 'siswa'])
                  ->default('guru')->change();
        });
    }

    public function down(): void
    {
        // Mengembalikan ke kondisi semula jika migrasi di-rollback
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru', 'kepala_sekolah'])
                  ->default('guru')->change();
        });
    }
};