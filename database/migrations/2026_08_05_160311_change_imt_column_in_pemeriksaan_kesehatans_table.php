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
            $table->decimal('imt', 5, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->decimal('imt', 4, 2)->change();
        });
    }
};
