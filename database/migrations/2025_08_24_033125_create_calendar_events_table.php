<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Agenda
            $table->dateTime('start'); // Waktu Mulai
            $table->dateTime('end')->nullable(); // Waktu Selesai (opsional)
            $table->string('color')->nullable(); // Warna kategori
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Null jika agenda sekolah, diisi jika agenda pribadi guru
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('calendar_events'); }
};