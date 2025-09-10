<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('assessment_learning_objective', function (Blueprint $table) {
            $table->primary(['assessment_id', 'learning_objective_id']);
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_objective_id')->constrained()->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('assessment_learning_objective'); }
};