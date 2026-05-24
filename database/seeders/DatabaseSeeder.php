<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FacultyAndProdiSeeder::class,
        ]);
        // Membuat Akun Admin
        User::create([
            'name' => 'Administrator Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password123'), // Gunakan Hash untuk keamanan
            'role' => 'admin',
        ]);

        // Membuat Akun Mahasiswa (untuk testing)
        User::create([
            'name' => 'Fajar Mahasiswa',
            'email' => 'mahasiswa@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // Membuat Akun Perawat (untuk testing)
        User::create([
            'name' => 'Siti Perawat',
            'email' => 'perawat@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'perawat',
        ]);
        
        // Membuat Akun Dokter (untuk testing)
        User::create([
            'name' => 'Budi Dokter',
            'email' => 'dokter@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'dokter',
        ]);
        
        echo "Seeder berhasil: Akun Admin, Mahasiswa, Perawat & Dokter telah dibuat.\n";
    }
}
