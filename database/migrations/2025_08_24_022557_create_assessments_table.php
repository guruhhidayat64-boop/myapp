<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Penilaian, cth: "Tes Formatif: Teks Deskripsi"
            $table->enum('type', ['Formatif', 'Sumatif']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Guru yang membuat
            $table->foreignId('class_id')->constrained()->onDelete('cascade'); // Untuk kelas spesifik (7A)
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->date('assessment_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('assessments'); }
};