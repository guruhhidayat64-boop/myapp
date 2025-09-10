<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('mentorship_group_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentorship_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->unique()->constrained()->onDelete('cascade'); // Unik, 1 siswa hanya punya 1 guru wali
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mentorship_group_student'); }
};
