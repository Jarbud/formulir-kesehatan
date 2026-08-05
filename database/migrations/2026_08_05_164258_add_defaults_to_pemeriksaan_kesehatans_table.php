<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->enum('ishihara', ['+', '-', 'parsial'])->nullable()->default(null)->change();
            $table->enum('kesimpulan', [
                'Layak',
                'Layak dengan Syarat',
                'Tidak Layak Mengikuti PKKMB'
            ])->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->enum('ishihara', ['+', '-', 'parsial'])->nullable(false)->change();
            $table->enum('kesimpulan', [
                'Layak',
                'Layak dengan Syarat',
                'Tidak Layak Mengikuti PKKMB'
            ])->nullable(false)->change();
        });
    }
};
