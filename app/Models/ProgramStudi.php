<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramStudi extends Model
{
    use HasFactory;

    // Mengunci nama tabel secara eksplisit agar sesuai dengan migration Anda
    protected $table = 'program_studis';

    // Menentukan kolom yang boleh diisi
    protected $fillable = ['faculty_id', 'level', 'name'];

    /**
     * Relasi balik ke model Faculty (BelongsTo).
     * Setiap Program Studi dimiliki oleh satu Fakultas.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
}