<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('development_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Siswa yang dicatat
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru Wali yang mencatat
            $table->date('log_date'); // Tanggal catatan dibuat
            $table->string('category'); // Kategori: Akademik, Kompetensi, Karakter
            $table->text('content'); // Isi catatan/observasi
            $table->text('follow_up')->nullable(); // Rencana tindak lanjut
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('development_logs'); }
};