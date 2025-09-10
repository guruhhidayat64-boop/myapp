<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'role' setelah kolom 'email'
            // ENUM berarti kolom ini hanya bisa diisi oleh salah satu dari nilai yang ada di dalam array.
            // Nilai defaultnya adalah 'guru'.
            $table->enum('role', ['admin', 'guru', 'kepala_sekolah'])
                  ->default('guru')
                  ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Perintah untuk menghapus kolom 'role' jika migrasi di-rollback
            $table->dropColumn('role');
        });
    }
};
