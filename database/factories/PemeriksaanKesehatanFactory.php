<?php

namespace Database\Factories;

use App\Models\PemeriksaanKesehatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PemeriksaanKesehatanFactory extends Factory
{
    protected $model = PemeriksaanKesehatan::class;

    public function definition(): array
    {
        return [
            'user_id'                   => User::factory()->state(['role' => 'mahasiswa']),
            'name'                      => fake()->name(),
            'nik'                       => fake()->numerify('################'),
            'nim'                       => fake()->numerify('##########'),
            'jenis_kelamin'             => fake()->randomElement(['laki-laki', 'perempuan']),
            'usia'                      => fake()->numberBetween(17, 25),
            'fakultas'                  => 'Fakultas Teknik',
            'prodi'                     => 'S1 Teknik Informatika',
            'tempat_tanggal_lahir'      => 'Malang, 01 Januari 2000',
            'alamat_asal'               => fake()->address(),
            'alamat_malang'             => fake()->address(),
            'wa'                        => '08' . fake()->numerify('#########'),
            'nama_wali'                 => fake()->name(),
            'wa_wali'                   => '08' . fake()->numerify('#########'),
            'skrining_kesehatan_mental' => 'Belum',
            'disabilitas'               => 'Tidak Ada',
            'tinggi_badan'              => fake()->randomFloat(2, 150, 190),
            'berat_badan'               => fake()->randomFloat(2, 45, 100),
            'imt'                       => fake()->randomFloat(2, 18, 30),
            'riwayat_sakit'             => null,
            'riwayat_kesehatan_fisik'   => 'Tidak ada',
            'keluhan'                   => null,
            'tekanan_darah'             => '120/80',
            'ishihara'                  => '+',
            'status_proses'             => 'perawat',
            'kesimpulan'                => 'Layak',
            'rekomendasi'               => null,
            'status_pembayaran'         => 'pending',
        ];
    }

    public function statusPerawat(): static
    {
        return $this->state(['status_proses' => 'perawat']);
    }

    public function statusDokter(): static
    {
        return $this->state(['status_proses' => 'dokter']);
    }

    public function statusAdmin(): static
    {
        return $this->state(['status_proses' => 'admin']);
    }

    public function statusSelesai(): static
    {
        return $this->state(['status_proses' => 'selesai']);
    }

    public function sudahBayar(): static
    {
        return $this->state([
            'status_pembayaran' => 'menunggu_verifikasi',
            'bukti_pembayaran'  => 'bukti_pembayaran/test.jpg',
        ]);
    }
}
