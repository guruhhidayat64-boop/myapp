<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flow_learning_objective', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teaching_flow_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_objective_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0); // Untuk menyimpan urutan
            $table->integer('estimated_hours')->nullable(); // Untuk Jam Pelajaran (JP)
            $table->text('notes')->nullable(); // Untuk catatan/materi/aktivitas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flow_learning_objective');
    }
};
