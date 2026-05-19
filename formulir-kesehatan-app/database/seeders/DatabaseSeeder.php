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
        
        echo "Seeder berhasil: Akun Admin & Mahasiswa telah dibuat.\n";
    }
}
