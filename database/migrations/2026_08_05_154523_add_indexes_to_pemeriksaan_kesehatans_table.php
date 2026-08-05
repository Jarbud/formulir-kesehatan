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
            $table->index('nim');
            $table->index('nik');
            $table->index('status_pembayaran');
            $table->index('status_proses');
        });
    }

    public function down(): void
    {
        Schema::table('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->dropIndex(['nim']);
            $table->dropIndex(['nik']);
            $table->dropIndex(['status_pembayaran']);
            $table->dropIndex(['status_proses']);
        });
    }
};
