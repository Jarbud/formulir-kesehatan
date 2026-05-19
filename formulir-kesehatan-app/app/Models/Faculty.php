<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi secara massal
    protected $fillable = ['name'];

    /**
     * Relasi ke model ProgramStudi (One-to-Many).
     * Satu Fakultas memiliki banyak Program Studi.
     */
    public function programStudis(): HasMany
    {
        // Parameter kedua adalah foreign_key di tabel program_studis
        return $this->hasMany(ProgramStudi::class, 'faculty_id');
    }
}