<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->string('academic_year')->nullable()->after('grade_level_id'); // Untuk Tahun Ajaran
            $table->string('semester')->nullable()->after('academic_year'); // Untuk Semester
        });
    }

    public function down(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->dropColumn(['academic_year', 'semester']);
        });
    }
};
