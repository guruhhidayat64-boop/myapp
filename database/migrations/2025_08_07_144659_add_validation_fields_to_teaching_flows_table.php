<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teaching_flows', function (Blueprint $table) {
            // Kolom untuk status validasi
            $table->string('status')->default('Menunggu Tinjauan')->after('description');
            // Kolom untuk catatan umpan balik dari kepala sekolah
            $table->text('feedback')->nullable()->after('status');
            // Kolom untuk mencatat siapa yang memvalidasi
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null')->after('feedback');
            // Kolom untuk mencatat kapan divalidasi
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    public function down(): void
    {
        Schema::table('teaching_flows', function (Blueprint $table) {
            $table->dropColumn(['status', 'feedback', 'validated_by', 'validated_at']);
        });
    }
};

