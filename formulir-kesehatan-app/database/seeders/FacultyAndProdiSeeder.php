<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultyAndProdiSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu untuk menghindari duplikasi saat run ulang (opsional)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('program_studis')->truncate();
        DB::table('faculties')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Master Data Gabungan: S1, D4, S2, dan S3
        $data = [
            'Fakultas Ilmu Pendidikan (FIP)' => [
                // S1
                ['level' => 'S1', 'name' => 'Bimbingan dan Konseling'],
                ['level' => 'S1', 'name' => 'Teknologi Pendidikan'],
                ['level' => 'S1', 'name' => 'Administrasi Pendidikan'],
                ['level' => 'S1', 'name' => 'Pendidikan Non Formal'],
                ['level' => 'S1', 'name' => 'Pendidikan Guru Sekolah Dasar'],
                ['level' => 'S1', 'name' => 'Pendidikan Guru Pendidikan Anak Usia Dini'],
                ['level' => 'S1', 'name' => 'Pendidikan Luar Biasa'],
                // S2
                ['level' => 'S2', 'name' => 'Bimbingan dan Konseling'], 
                ['level' => 'S2', 'name' => 'Teknologi Pembelajaran'], 
                ['level' => 'S2', 'name' => 'Manajemen Pendidikan'], 
                ['level' => 'S2', 'name' => 'Pendidikan Luar Sekolah'], 
                ['level' => 'S2', 'name' => 'Pendidikan Anak Usia Dini'], 
                ['level' => 'S2', 'name' => 'Pendidikan Khusus'], 
                // S3
                ['level' => 'S3', 'name' => 'Bimbingan dan Konseling'], 
                ['level' => 'S3', 'name' => 'Teknologi Pembelajaran'], 
                ['level' => 'S3', 'name' => 'Manajemen Pendidikan'], 
                ['level' => 'S3', 'name' => 'Pendidikan Luar Sekolah'], 
            ],
            'Fakultas Sastra (FS)' => [
                // S1
                ['level' => 'S1', 'name' => 'Pendidikan Bahasa, Sastra Indonesia dan Daerah'],
                ['level' => 'S1', 'name' => 'Bahasa dan Sastra Indonesia'],
                ['level' => 'S1', 'name' => 'Ilmu Perpustakaan'],
                ['level' => 'S1', 'name' => 'Pendidikan Bahasa Inggris'],
                ['level' => 'S1', 'name' => 'Bahasa dan Sastra Inggris'],
                ['level' => 'S1', 'name' => 'Pendidikan Bahasa Arab'],
                ['level' => 'S1', 'name' => 'Pendidikan Bahasa Jerman'],
                ['level' => 'S1', 'name' => 'Pendidikan Bahasa Mandarin'],
                ['level' => 'S1', 'name' => 'Pendidikan Seni Rupa'],
                ['level' => 'S1', 'name' => 'Pendidikan Seni Tari dan Musik'],
                // S2
                ['level' => 'S2', 'name' => 'Pendidikan Bahasa Indonesia'], 
                ['level' => 'S2', 'name' => 'Pendidikan Bahasa Inggris'], 
                ['level' => 'S2', 'name' => 'Keguruan Bahasa Arab'], 
                // S3
                ['level' => 'S3', 'name' => 'Pendidikan Bahasa Indonesia'], 
                ['level' => 'S3', 'name' => 'Pendidikan Bahasa Inggris'], 
                ['level' => 'S3', 'name' => 'Pendidikan Bahasa Arab'], 
            ],
            'Fakultas Matematika dan IPA (FMIPA)' => [
                // S1
                ['level' => 'S1', 'name' => 'Matematika'],
                ['level' => 'S1', 'name' => 'Sains Aktuaria'],
                ['level' => 'S1', 'name' => 'Pendidikan Fisika'],
                ['level' => 'S1', 'name' => 'Fisika'],
                ['level' => 'S1', 'name' => 'Pendidikan Kimia'],
                ['level' => 'S1', 'name' => 'Kimia'],
                ['level' => 'S1', 'name' => 'Pendidikan Biologi'],
                ['level' => 'S1', 'name' => 'Biologi'],
                ['level' => 'S1', 'name' => 'Bioteknologi'],
                ['level' => 'S1', 'name' => 'Gizi'],
                ['level' => 'S1', 'name' => 'Pendidikan Ilmu Pengetahuan Alam'],
                // S2
                ['level' => 'S2', 'name' => 'Pendidikan Matematika'], 
                ['level' => 'S2', 'name' => 'Matematika'], 
                ['level' => 'S2', 'name' => 'Pendidikan Fisika'], 
                ['level' => 'S2', 'name' => 'Fisika'], 
                ['level' => 'S2', 'name' => 'Pendidikan Kimia'], // Rekonstruksi dari teks terpotong halaman 1 [cite: 41]
                ['level' => 'S2', 'name' => 'Kimia'],
                ['level' => 'S2', 'name' => 'Pendidikan Biologi'],
                ['level' => 'S2', 'name' => 'Biologi'], 
                ['level' => 'S2', 'name' => 'Bioteknologi'],
                ['level' => 'S2', 'name' => 'Pendidikan IPA'],
                // S3
                ['level' => 'S3', 'name' => 'Pendidikan Matematika'], 
                ['level' => 'S3', 'name' => 'Pendidikan Fisika'], 
                ['level' => 'S3', 'name' => 'Pendidikan Kimia'],
                ['level' => 'S3', 'name' => 'Pendidikan Biologi'],
                ['level' => 'S3', 'name' => 'Pendidikan Ilmu Pengetahuan Alam'], // Rekonstruksi teks 'S3 Ilmu Al' [cite: 59]
            ],
            'Fakultas Ekonomi dan Bisnis (FEB)' => [
                // S1 & D4
                ['level' => 'S1', 'name' => 'Pendidikan Tata Niaga'],
                ['level' => 'S1', 'name' => 'Pendidikan Administrasi Perkantoran'],
                ['level' => 'S1', 'name' => 'Manajemen'],
                ['level' => 'S1', 'name' => 'Pendidikan Akuntansi'],
                ['level' => 'S1', 'name' => 'Akuntansi'],
                ['level' => 'S1', 'name' => 'Pendidikan Ekonomi'],
                ['level' => 'S1', 'name' => 'Ekonomi Pembangunan'],
                ['level' => 'D4', 'name' => 'Manajemen Pemasaran'],
                ['level' => 'D4', 'name' => 'Akuntansi'],
                // S2
                ['level' => 'S2', 'name' => 'Manajemen'], 
                ['level' => 'S2', 'name' => 'Pendidikan Bisnis dan Manajemen'],
                ['level' => 'S2', 'name' => 'Akuntansi'], 
                ['level' => 'S2', 'name' => 'Pendidikan Ekonomi'],
                ['level' => 'S2', 'name' => 'Ilmu Ekonomi'], 
                // S3
                ['level' => 'S3', 'name' => 'Akuntansi'],
                ['level' => 'S3', 'name' => 'Manajemen'],
                ['level' => 'S3', 'name' => 'Pendidikan Ekonomi'], 
                ['level' => 'S3', 'name' => 'Ilmu Ekonomi'],
            ],
            'Fakultas Teknik (FT)' => [
                // S1 & D4
                ['level' => 'S1', 'name' => 'Pendidikan Teknik Mesin'],
                ['level' => 'S1', 'name' => 'Pendidikan Teknik Otomotif'],
                ['level' => 'S1', 'name' => 'Teknik Mesin'],
                ['level' => 'S1', 'name' => 'Teknik Industri'],
                ['level' => 'S1', 'name' => 'Pendidikan Teknik Bangunan'],
                ['level' => 'S1', 'name' => 'Arsitektur'],
                ['level' => 'S1', 'name' => 'Teknik Lingkungan'],
                ['level' => 'S1', 'name' => 'Pendidikan Teknik Informatika'],
                ['level' => 'S1', 'name' => 'Pendidikan Teknik Elektro'],
                ['level' => 'S1', 'name' => 'Teknik Informatika'],
                ['level' => 'S1', 'name' => 'Teknik Elektro'],
                ['level' => 'S1', 'name' => 'Pendidikan Tata Boga'],
                ['level' => 'S1', 'name' => 'Pendidikan Tata Busana'],
                ['level' => 'D4', 'name' => 'Animasi'],
                ['level' => 'D4', 'name' => 'Teknologi Rekayasa Otomotif'],
                ['level' => 'D4', 'name' => 'Teknologi Rekayasa dan Pemeliharaan Bangunan Sipil'],
                ['level' => 'D4', 'name' => 'Teknologi Rekayasa Manufaktur'],
                ['level' => 'D4', 'name' => 'Teknologi Rekayasa Pembangkit Energi'],
                ['level' => 'D4', 'name' => 'Teknologi Rekayasa Sistem Elektronika'],
                ['level' => 'D4', 'name' => 'Tata Boga'],
                ['level' => 'D4', 'name' => 'Desain Mode'],
                // S2
                ['level' => 'S2', 'name' => 'Teknik Mesin'], 
                ['level' => 'S2', 'name' => 'Teknik Sipil'], 
                ['level' => 'S2', 'name' => 'Teknik Elektro'], 
                ['level' => 'S2', 'name' => 'Pendidikan Kejuruan'],
                // S3
                ['level' => 'S3', 'name' => 'Teknik Elektro dan Informatika'], 
                ['level' => 'S3', 'name' => 'Teknik Mesin'], 
            ],
            'Fakultas Ilmu Keolahragaan (FIK)' => [
                // S1
                ['level' => 'S1', 'name' => 'Pendidikan Jasmani, Kesehatan dan Rekreasi'],
                ['level' => 'S1', 'name' => 'Ilmu Kesehatan Masyarakat'],
                ['level' => 'S1', 'name' => 'Ilmu Keolahragaan'],
                ['level' => 'S1', 'name' => 'Pendidikan Kepelatihan Olahraga'],
                // S2
                ['level' => 'S2', 'name' => 'Pendidikan Olahraga'], 
            ],
            'Fakultas Ilmu Sosial (FIS)' => [
                // S1
                ['level' => 'S1', 'name' => 'Pendidikan Pancasila dan Kewarganegaraan'],
                ['level' => 'S1', 'name' => 'Hukum'],
                ['level' => 'S1', 'name' => 'Pendidikan Geografi'],
                ['level' => 'S1', 'name' => 'Geografi'],
                ['level' => 'S1', 'name' => 'Pendidikan Sejarah'],
                ['level' => 'S1', 'name' => 'Ilmu Sejarah'],
                ['level' => 'S1', 'name' => 'Pendidikan Ilmu Pengetahuan Sosial'],
                ['level' => 'S1', 'name' => 'Pendidikan Sosiologi'],
                ['level' => 'S1', 'name' => 'Ilmu Komunikasi'],
                ['level' => 'S1', 'name' => 'Pariwisata'],
                // S2
                ['level' => 'S2', 'name' => 'Pendidikan Pancasila dan Kewarganegaraan'], 
                ['level' => 'S2', 'name' => 'Pendidikan Geografi'], 
                ['level' => 'S2', 'name' => 'Pendidikan Sejarah'], 
                // S3
                ['level' => 'S3', 'name' => 'Pendidikan Geografi'], 
            ],
            'Fakultas Kedokteran (FK)' => [
                // S1
                ['level' => 'S1', 'name' => 'Kedokteran'],
                ['level' => 'S1', 'name' => 'Keperawatan'],
                ['level' => 'S1', 'name' => 'Kebidanan'],
            ],
            'Fakultas Psikologi (FPsi)' => [ // Unit Baru di Pascasarjana
                // S2
                ['level' => 'S2', 'name' => 'Psikologi'], 
                // S3
                ['level' => 'S3', 'name' => 'Psikologi Pendidikan'], 
            ],
            'Sekolah Pascasarjana (SPs)' => [ // Unit Non-Fakultas Khusus Pascasarjana
                // S2
                ['level' => 'S2', 'name' => 'Pendidikan Dasar'], 
                ['level' => 'S2', 'name' => 'Pendidikan Kejuruan'], 
                ['level' => 'S2', 'name' => 'Pendidikan Bahasa Indonesia Bagi Penutur Asing (BIPA)'], 
                // S3
                ['level' => 'S3', 'name' => 'Pendidikan Dasar'], 
                ['level' => 'S3', 'name' => 'Pendidikan Kejuruan'], 
            ]
        ];

        // Eksekusi Loop Pengisian Database
        foreach ($data as $facultyName => $prodis) {
            // Simpan nama Fakultas ke tabel `faculties`
            $facultyId = DB::table('faculties')->insertGetId([
                'name' => $facultyName,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Simpan seluruh relasi Prodi ke tabel `program_studis`
            foreach ($prodis as $prodi) {
                DB::table('program_studis')->insert([
                    'faculty_id' => $facultyId,
                    'level' => $prodi['level'],
                    'name' => $prodi['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}