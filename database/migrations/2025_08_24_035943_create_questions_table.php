<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru pembuat soal
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['Pilihan Ganda', 'Esai']);
            $table->text('question_text'); // Isi/badan soal
            $table->json('options')->nullable(); // Untuk menyimpan pilihan A, B, C, D dalam format JSON
            $table->string('answer_key')->nullable(); // Untuk menyimpan kunci jawaban (misal: "A")
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('questions'); }
};