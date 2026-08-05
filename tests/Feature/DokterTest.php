<?php

namespace Tests\Feature;

use App\Models\PemeriksaanKesehatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DokterTest extends TestCase
{
    use RefreshDatabase;

    private function dokter(): User
    {
        return User::factory()->create(['role' => 'dokter']);
    }

    private function mahasiswaWithPemeriksaan(): array
    {
        $mahasiswa   = User::factory()->create(['role' => 'mahasiswa']);
        $pemeriksaan = PemeriksaanKesehatan::factory()->statusDokter()->create(['user_id' => $mahasiswa->id]);
        return [$mahasiswa, $pemeriksaan];
    }

    public function test_dokter_can_access_dashboard(): void
    {
        $dokter = $this->dokter();
        $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($dokter)->get('/dokter/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('dokter.dashboard');
    }

    public function test_non_dokter_redirected_from_dokter_dashboard(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $response  = $this->actingAs($mahasiswa)->get('/dokter/dashboard');
        $response->assertRedirect('dashboard');
    }

    public function test_dokter_can_access_detail_mahasiswa(): void
    {
        $dokter            = $this->dokter();
        [$mahasiswa, ]     = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($dokter)->get("/dokter/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $response->assertViewIs('dokter.detail_mahasiswa');
    }

    public function test_dokter_can_update_pemeriksaan(): void
    {
        $dokter                    = $this->dokter();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($dokter)->put("/dokter/pemeriksaan/{$pemeriksaan->id}", [
            'kesimpulan'  => 'Layak',
            'rekomendasi' => 'Tidak ada rekomendasi khusus',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'            => $pemeriksaan->id,
            'kesimpulan'    => 'Layak',
            'status_proses' => 'admin',
        ]);
    }

    public function test_dokter_update_sets_id_dokter_acc(): void
    {
        $dokter                    = $this->dokter();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $this->actingAs($dokter)->put("/dokter/pemeriksaan/{$pemeriksaan->id}", [
            'kesimpulan'  => 'Layak',
            'rekomendasi' => null,
        ]);

        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'            => $pemeriksaan->id,
            'id_dokter_acc' => $dokter->id,
        ]);
    }

    public function test_dokter_mahasiswa_with_status_perawat_returns_empty_riwayat(): void
    {
        $dokter    = $this->dokter();
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        PemeriksaanKesehatan::factory()->statusPerawat()->create(['user_id' => $mahasiswa->id]);

        $response = $this->actingAs($dokter)->get("/dokter/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $riwayats = $response->viewData('riwayats');
        $this->assertCount(0, $riwayats);
    }
}
