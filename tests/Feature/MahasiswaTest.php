<?php

namespace Tests\Feature;

use App\Models\Faculty;
use App\Models\PemeriksaanKesehatan;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    private function mahasiswa(): User
    {
        return User::factory()->create(['role' => 'mahasiswa']);
    }

    private function fakultasWithProdi(): Faculty
    {
        $faculty = Faculty::factory()->create(['name' => 'Fakultas Teknik']);
        ProgramStudi::factory()->create([
            'faculty_id' => $faculty->id,
            'level'      => 'S1',
            'name'       => 'Teknik Informatika',
        ]);
        return $faculty;
    }

    private function formulirData(Faculty $faculty): array
    {
        return [
            'name'                      => 'Budi Mahasiswa',
            'nik'                       => '1234567890123456',
            'nim'                       => '2024001001',
            'jenis_kelamin'             => 'laki-laki',
            'usia'                      => 20,
            'fakultas'                  => $faculty->id,
            'fakultas_nama'             => $faculty->name,
            'prodi'                     => 'S1 Teknik Informatika',
            'tempat_tanggal_lahir'      => 'Malang, 01 Januari 2004',
            'alamat_asal'               => 'Jl. Merdeka No. 1, Malang',
            'alamat_malang'             => 'Jl. Soekarno Hatta No. 2, Malang',
            'wa'                        => '08123456789',
            'nama_wali'                 => 'Bapak Wali',
            'wa_wali'                   => '08198765432',
            'skrining_kesehatan_mental' => 'Belum',
            'disabilitas'               => 'Tidak Ada',
            'tinggi_badan'              => 170,
            'berat_badan'               => 65,
            'imt'                       => 22.5,
            'riwayat_sakit'             => null,
            'riwayat_kesehatan_fisik'   => 'Tidak ada',
            'keluhan'                   => null,
        ];
    }

    public function test_mahasiswa_can_access_formulir_page(): void
    {
        $user = $this->mahasiswa();
        $this->fakultasWithProdi();

        $response = $this->actingAs($user)->get('/formulir');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.formulir');
        $response->assertViewHas('faculties');
    }

    public function test_non_mahasiswa_redirected_from_formulir(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/formulir');

        $response->assertRedirect('dashboard');
    }

    public function test_guest_cannot_access_formulir(): void
    {
        $response = $this->get('/formulir');

        $response->assertRedirect('/login');
    }

    public function test_mahasiswa_can_submit_formulir(): void
    {
        $this->withoutExceptionHandling();
        $user    = $this->mahasiswa();
        $faculty = $this->fakultasWithProdi();

        $response = $this->actingAs($user)->post('/simpan-data', $this->formulirData($faculty));

        $sessionError = $response->getSession()->get('error');
        if ($sessionError) {
            $this->fail('Controller error: ' . $sessionError);
        }

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'user_id'       => $user->id,
            'nim'           => '2024001001',
            'status_proses' => 'perawat',
        ]);
    }

    public function test_formulir_validation_requires_tinggi_badan(): void
    {
        $user    = $this->mahasiswa();
        $faculty = $this->fakultasWithProdi();
        $data    = $this->formulirData($faculty);
        unset($data['tinggi_badan']);

        $response = $this->actingAs($user)->post('/simpan-data', $data);

        $response->assertSessionHasErrors('tinggi_badan');
    }

    public function test_formulir_validation_tinggi_badan_min_100(): void
    {
        $user    = $this->mahasiswa();
        $faculty = $this->fakultasWithProdi();
        $data    = $this->formulirData($faculty);
        $data['tinggi_badan'] = 77;
        $data['imt'] = 121.4;

        $response = $this->actingAs($user)->post('/simpan-data', $data);

        $response->assertSessionHasErrors('tinggi_badan');
    }

    public function test_formulir_validation_berat_badan_min_20(): void
    {
        $user    = $this->mahasiswa();
        $faculty = $this->fakultasWithProdi();
        $data    = $this->formulirData($faculty);
        $data['berat_badan'] = 10;

        $response = $this->actingAs($user)->post('/simpan-data', $data);

        $response->assertSessionHasErrors('berat_badan');
    }

    public function test_mahasiswa_can_access_bayar_page(): void
    {
        $user = $this->mahasiswa();
        $pemeriksaan = PemeriksaanKesehatan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/bayar/{$pemeriksaan->id}");

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.bayar');
    }

    public function test_mahasiswa_can_upload_bukti_pembayaran(): void
    {
        Storage::fake('public');
        $user        = $this->mahasiswa();
        $pemeriksaan = PemeriksaanKesehatan::factory()->create(['user_id' => $user->id]);
        $file        = UploadedFile::fake()->image('bukti.jpg');

        $response = $this->actingAs($user)->post('/upload-bukti', [
            'pemeriksaan_id'   => $pemeriksaan->id,
            'bukti_pembayaran' => $file,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'                => $pemeriksaan->id,
            'status_pembayaran' => 'menunggu_verifikasi',
        ]);
    }

    public function test_upload_bukti_requires_valid_file(): void
    {
        $user        = $this->mahasiswa();
        $pemeriksaan = PemeriksaanKesehatan::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post('/upload-bukti', [
            'pemeriksaan_id'   => $pemeriksaan->id,
            'bukti_pembayaran' => 'bukan-file',
        ]);

        $response->assertSessionHasErrors('bukti_pembayaran');
    }

    public function test_mahasiswa_can_access_riwayat(): void
    {
        $user = $this->mahasiswa();
        PemeriksaanKesehatan::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/riwayat');

        $response->assertStatus(200);
        $response->assertViewIs('mahasiswa.riwayat');
        $response->assertViewHas('riwayats');
    }

    public function test_mahasiswa_only_sees_own_riwayat(): void
    {
        $user1 = $this->mahasiswa();
        $user2 = $this->mahasiswa();
        PemeriksaanKesehatan::factory()->count(2)->create(['user_id' => $user1->id]);
        PemeriksaanKesehatan::factory()->count(3)->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get('/riwayat');

        $riwayats = $response->viewData('riwayats');
        $this->assertCount(2, $riwayats);
    }
}
