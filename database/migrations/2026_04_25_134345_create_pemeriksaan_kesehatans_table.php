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
        Schema::create('pemeriksaan_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Data Identitas (Meskipun ada di Auth, sebaiknya di-snapshot saat periksa)
            $table->string('name')->nullable();
            $table->string('nik')->nullable();
            $table->string('nim')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->integer('usia');
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('tempat_tanggal_lahir');
            $table->text('alamat_asal')->nullable();
            $table->text('alamat_malang')->nullable();
            $table->string('wa')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('wa_wali')->nullable();
            $table->string('disabilitas')->default('Tidak Ada');
            
            // Data Fisik & Medis
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('imt', 4, 2);
            $table->string('riwayat_sakit')->nullable();
            $table->text('riwayat_kesehatan_fisik')->nullable();
            $table->text('keluhan')->nullable();

            $table->text('tekanan_darah')->nullable();
            $table->enum('ishihara', ['+', '-', 'parsial']);
            $table->enum('status_proses', ['perawat', 'dokter', 'admin', 'selesai']);

            // Menambahkan kolom enum kesimpulan setelah kolom status_proses
            $table->enum('kesimpulan', [
                'Layak', 
                'Layak dengan Syarat', 
                'Tidak Layak Mengikuti PKKMB'
            ])->after('status_proses');

            // Menambahkan kolom rekomendasi berupa text dan boleh kosong (nullable)
            $table->text('rekomendasi')->nullable()->after('kesimpulan');
            
            $table->string('status_pembayaran')->default('pending'); // Karena ada tombol 'Simpan & Bayar'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_kesehatans');
    }
};
