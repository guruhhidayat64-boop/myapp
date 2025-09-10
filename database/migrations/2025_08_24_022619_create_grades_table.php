<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('score')->nullable(); // Dibuat string agar fleksibel (angka, "Tercapai", dll)
            $table->text('notes')->nullable(); // Catatan kualitatif
            $table->timestamps();
            $table->unique(['assessment_id', 'student_id']); // Satu siswa satu nilai per asesmen
        });
    }
    public function down(): void { Schema::dropIfExists('grades'); }
};