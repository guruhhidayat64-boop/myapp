<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            // Menambahkan kolom untuk pilar "Identifikasi"
            $table->text('initial_assessment')->nullable()->after('duration_in_minutes');
            $table->json('graduate_profile_dimensions')->nullable()->after('initial_assessment');

            // Menambahkan kolom untuk pilar "Desain Pembelajaran"
            $table->text('pedagogical_practices')->nullable()->after('essential_questions');
            $table->text('partnership')->nullable()->after('pedagogical_practices');
            $table->text('learning_environment')->nullable()->after('partnership');
            $table->text('digital_utilization')->nullable()->after('learning_environment');
        });
    }

    public function down(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->dropColumn([
                'initial_assessment', 'graduate_profile_dimensions', 'pedagogical_practices',
                'partnership', 'learning_environment', 'digital_utilization'
            ]);
        });
    }
};
