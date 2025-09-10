<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kktp', function (Blueprint $table) {
            $table->id();
            // Setiap KKTP harus terhubung ke satu Tujuan Pembelajaran
            $table->foreignId('learning_objective_id')->unique()->constrained()->onDelete('cascade');
            // Menyimpan jenis pendekatan yang dipilih (rubrik, deskripsi, dll.)
            $table->string('type');
            // Kolom JSON untuk menyimpan data kriteria yang fleksibel
            $table->json('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kktp');
    }
};
