<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('mentorship_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Kelompok, misal: "Kelompok Bimbingan Angkatan 2025 - A"
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // ID Guru Wali, unik karena 1 guru 1 kelompok
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mentorship_groups'); }
};