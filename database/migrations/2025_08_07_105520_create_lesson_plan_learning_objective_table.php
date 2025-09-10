<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_plan_learning_objective', function (Blueprint $table) {
            $table->primary(['lesson_plan_id', 'learning_objective_id']); // Kunci utama gabungan

            $table->foreignId('lesson_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_objective_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_plan_learning_objective');
    }
};