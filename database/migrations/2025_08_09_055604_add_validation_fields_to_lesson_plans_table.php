<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->string('status')->default('Menunggu Tinjauan')->after('title');
            $table->text('feedback')->nullable()->after('status');
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null')->after('feedback');
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    public function down(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->dropColumn(['status', 'feedback', 'validated_by', 'validated_at']);
        });
    }
};