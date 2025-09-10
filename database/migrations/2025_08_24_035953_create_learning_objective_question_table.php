<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('learning_objective_question', function (Blueprint $table) {
            $table->primary(['learning_objective_id', 'question_id']);
            $table->foreignId('learning_objective_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('learning_objective_question'); }
};