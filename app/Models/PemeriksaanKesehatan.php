<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanKesehatan extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'nik', 'nim', 'jenis_kelamin', 'usia', 'fakultas', 
        'prodi', 'tempat_tanggal_lahir', 'disabilitas', 'tinggi_badan', 
        'berat_badan', 'imt', 'riwayat_sakit', 'keluhan', 
        'status_pembayaran', 'bukti_pembayaran'
    ];
}
