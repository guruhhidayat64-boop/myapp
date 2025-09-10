<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained()->onDelete('cascade'); // ID dari tabel classes (7A, 7B, dst)
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('academic_year'); // Contoh: "2025/2026"
            $table->timestamps();

            // Mencegah duplikasi: satu siswa tidak bisa ada di kelas yang sama di tahun ajaran yang sama
            $table->unique(['class_id', 'student_id', 'academic_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_student');
    }
};
