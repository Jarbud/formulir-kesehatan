<?php

namespace Tests\Feature;

use App\Models\PemeriksaanKesehatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerawatTest extends TestCase
{
    use RefreshDatabase;

    private function perawat(): User
    {
        return User::factory()->create(['role' => 'perawat']);
    }

    private function mahasiswaWithPemeriksaan(): array
    {
        $mahasiswa   = User::factory()->create(['role' => 'mahasiswa']);
        $pemeriksaan = PemeriksaanKesehatan::factory()->statusPerawat()->create(['user_id' => $mahasiswa->id]);
        return [$mahasiswa, $pemeriksaan];
    }

    public function test_perawat_can_access_dashboard(): void
    {
        $perawat = $this->perawat();
        $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($perawat)->get('/perawat/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('perawat.dashboard');
    }

    public function test_non_perawat_redirected_from_perawat_dashboard(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $response  = $this->actingAs($mahasiswa)->get('/perawat/dashboard');
        $response->assertRedirect('dashboard');
    }

    public function test_perawat_can_access_detail_mahasiswa(): void
    {
        $perawat              = $this->perawat();
        [$mahasiswa, ]        = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($perawat)->get("/perawat/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $response->assertViewIs('perawat.detail_mahasiswa');
    }

    public function test_perawat_can_update_pemeriksaan(): void
    {
        $perawat             = $this->perawat();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($perawat)->put("/perawat/pemeriksaan/{$pemeriksaan->id}", [
            'tekanan_darah' => '120/80',
            'ishihara'      => '+',
            'lingkar_perut' => 80,
            'gula_darah'    => 95,
            'visus_mata'    => 'Normal',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'            => $pemeriksaan->id,
            'tekanan_darah' => '120/80',
            'status_proses' => 'dokter',
        ]);
    }

    public function test_perawat_update_sets_id_perawat_acc(): void
    {
        $perawat             = $this->perawat();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $this->actingAs($perawat)->put("/perawat/pemeriksaan/{$pemeriksaan->id}", [
            'tekanan_darah' => '120/80',
            'ishihara'      => '+',
            'lingkar_perut' => 80,
            'gula_darah'    => 95,
            'visus_mata'    => 'Normal',
        ]);

        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'             => $pemeriksaan->id,
            'id_perawat_acc' => $perawat->id,
        ]);
    }

    public function test_perawat_mahasiswa_with_status_dokter_returns_empty_riwayat(): void
    {
        $perawat   = $this->perawat();
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        PemeriksaanKesehatan::factory()->statusDokter()->create(['user_id' => $mahasiswa->id]);

        $response = $this->actingAs($perawat)->get("/perawat/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $riwayats = $response->viewData('riwayats');
        $this->assertCount(0, $riwayats);
    }
}
