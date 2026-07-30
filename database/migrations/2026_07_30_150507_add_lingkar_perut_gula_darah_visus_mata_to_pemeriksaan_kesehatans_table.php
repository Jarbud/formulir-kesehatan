<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->decimal('lingkar_perut', 5, 2)->nullable()->after('ishihara');
            $table->decimal('gula_darah', 6, 2)->nullable()->after('lingkar_perut');
            $table->enum('visus_mata', ['Normal', 'Gangguan'])->nullable()->after('gula_darah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->dropColumn(['lingkar_perut', 'gula_darah', 'visus_mata']);
        });
    }
};
