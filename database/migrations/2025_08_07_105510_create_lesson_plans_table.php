<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Modul Ajar
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru pembuat
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade');
            $table->integer('duration_in_minutes')->nullable(); // Alokasi Waktu

            // Komponen Inti (dibuat sebagai TEXT agar bisa diisi konten yang panjang)
            $table->text('meaningful_understanding')->nullable(); // Pemahaman Bermakna
            $table->text('essential_questions')->nullable(); // Pertanyaan Pemantik

            // Langkah-langkah Kegiatan Pembelajaran (disimpan sebagai JSON)
            $table->json('learning_activities')->nullable(); 

            // Asesmen (disimpan sebagai JSON)
            $table->json('assessment')->nullable();

            // Lampiran
            $table->text('student_worksheet')->nullable(); // Lembar Kerja Siswa
            $table->text('reading_materials')->nullable(); // Bahan Bacaan
            $table->text('glossary')->nullable(); // Glosarium
            $table->text('bibliography')->nullable(); // Daftar Pustaka

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};