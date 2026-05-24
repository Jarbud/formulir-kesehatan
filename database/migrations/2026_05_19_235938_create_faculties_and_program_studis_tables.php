<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Fakultas
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: FIP, FS, FEB, dll.
            $table->timestamps();
        });

        // Tabel Program Studi
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            $table->string('level'); // S1 atau D4
            $table->string('name');  // Nama Jurusan/Prodi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studis');
        Schema::dropIfExists('faculties');
    }
};