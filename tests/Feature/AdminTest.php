<?php

namespace Tests\Feature;

use App\Models\PemeriksaanKesehatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function mahasiswaWithPemeriksaan(string $status = 'admin'): array
    {
        $mahasiswa   = User::factory()->create(['role' => 'mahasiswa']);
        $pemeriksaan = PemeriksaanKesehatan::factory()->state(['status_proses' => $status])->create(['user_id' => $mahasiswa->id]);
        return [$mahasiswa, $pemeriksaan];
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_non_admin_redirected_from_admin_dashboard(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $response  = $this->actingAs($mahasiswa)->get('/admin/dashboard');
        $response->assertRedirect('dashboard');
    }

    public function test_admin_can_access_users_index(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/users');
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_admin_can_create_user(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name'                  => 'Perawat Baru',
            'email'                 => 'perawat.baru@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'perawat',
            'nip'                   => '123456789',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'perawat.baru@test.com',
            'role'  => 'perawat',
        ]);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = $this->admin();
        $user  = User::factory()->create(['role' => 'perawat']);

        $response = $this->actingAs($admin)->delete("/admin/users/{$user->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_access_detail_mahasiswa(): void
    {
        $admin             = $this->admin();
        [$mahasiswa, ]     = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($admin)->get("/admin/mahasiswa/{$mahasiswa->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.detail_mahasiswa');
    }

    public function test_admin_can_update_status_pembayaran(): void
    {
        $admin                     = $this->admin();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($admin)->put("/admin/pemeriksaan/{$pemeriksaan->id}", [
            'status_pembayaran' => 'lunas',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'                => $pemeriksaan->id,
            'status_pembayaran' => 'lunas',
        ]);
    }

    public function test_admin_can_set_pemeriksaan_selesai(): void
    {
        $admin                     = $this->admin();
        [$mahasiswa, $pemeriksaan] = $this->mahasiswaWithPemeriksaan();

        $response = $this->actingAs($admin)->put("/admin/pemeriksaan/{$pemeriksaan->id}/ttd");

        $response->assertRedirect();
        $this->assertDatabaseHas('pemeriksaan_kesehatans', [
            'id'            => $pemeriksaan->id,
            'status_proses' => 'selesai',
        ]);
    }

    public function test_admin_can_access_laporan(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/laporan');
        $response->assertStatus(200);
        $response->assertViewIs('admin.laporan');
    }

    public function test_admin_can_access_rangkuman(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/rangkuman');
        $response->assertStatus(200);
        $response->assertViewIs('admin.rangkuman');
    }
}
