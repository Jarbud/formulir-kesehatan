<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeriksaanKesehatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'nik', 'nim', 'jenis_kelamin', 'usia', 'fakultas', 'tekanan_darah', 'ishihara',
        'lingkar_perut', 'gula_darah', 'visus_mata',
        'prodi', 'tempat_tanggal_lahir', 'alamat_asal', 'alamat_malang', 'wa', 'nama_wali', 'wa_wali', 'skrining_kesehatan_mental', 'disabilitas', 'tinggi_badan', 
        'berat_badan', 'imt', 'riwayat_sakit', 'riwayat_kesehatan_fisik', 'keluhan', 'status_proses',
        'status_pembayaran', 'bukti_pembayaran',
        'kesimpulan', 'rekomendasi', 'exported_at'
    ];

    // Relasi ke Perawat yang melakukan ACC
    public function perawat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_perawat_acc');
    }

    // Relasi ke Dokter yang melakukan ACC
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dokter_acc');
    }
}

