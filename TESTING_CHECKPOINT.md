# Testing Checkpoint — Formulir Kesehatan App

**Tanggal:** 2026-08-05  
**Laravel Version:** 12.57.0  
**PHP:** XAMPP (Windows)  
**Database Testing:** SQLite in-memory  
**Total Tests:** 58 passed, 0 failed  

---

## Hasil Testing

### Auth (25 tests) — PASS
| Test | Status |
|------|--------|
| login screen can be rendered | ✅ |
| users can authenticate using the login screen | ✅ |
| users can not authenticate with invalid password | ✅ |
| users can logout | ✅ |
| email verification screen can be rendered | ✅ |
| email can be verified | ✅ |
| email is not verified with invalid hash | ✅ |
| confirm password screen can be rendered | ✅ |
| password can be confirmed | ✅ |
| password is not confirmed with invalid password | ✅ |
| reset password link screen can be rendered | ✅ |
| reset password link can be requested | ✅ |
| reset password screen can be rendered | ✅ |
| password can be reset with valid token | ✅ |
| password can be updated | ✅ |
| correct password must be provided to update password | ✅ |
| registration screen can be rendered | ✅ |
| new users can register | ✅ |
| profile page is displayed | ✅ |
| profile information can be updated | ✅ |
| email verification status is unchanged when email unchanged | ✅ |
| user can delete their account | ✅ |
| correct password must be provided to delete account | ✅ |

### Mahasiswa (12 tests) — PASS
| Test | Status |
|------|--------|
| mahasiswa can access formulir page | ✅ |
| non mahasiswa redirected from formulir | ✅ |
| guest cannot access formulir | ✅ |
| mahasiswa can submit formulir | ✅ |
| formulir validation requires tinggi badan | ✅ |
| formulir validation tinggi badan min 100 | ✅ |
| formulir validation berat badan min 20 | ✅ |
| mahasiswa can access bayar page | ✅ |
| mahasiswa can upload bukti pembayaran | ✅ |
| upload bukti requires valid file | ✅ |
| mahasiswa can access riwayat | ✅ |
| mahasiswa only sees own riwayat | ✅ |

### Perawat (6 tests) — PASS
| Test | Status |
|------|--------|
| perawat can access dashboard | ✅ |
| non perawat redirected from perawat dashboard | ✅ |
| perawat can access detail mahasiswa | ✅ |
| perawat can update pemeriksaan | ✅ |
| perawat update sets id_perawat_acc | ✅ |
| perawat mahasiswa with status dokter returns empty riwayat | ✅ |

### Dokter (6 tests) — PASS
| Test | Status |
|------|--------|
| dokter can access dashboard | ✅ |
| non dokter redirected from dokter dashboard | ✅ |
| dokter can access detail mahasiswa | ✅ |
| dokter can update pemeriksaan | ✅ |
| dokter update sets id_dokter_acc | ✅ |
| dokter mahasiswa with status perawat returns empty riwayat | ✅ |

### Admin (10 tests) — PASS
| Test | Status |
|------|--------|
| admin can access dashboard | ✅ |
| non admin redirected from admin dashboard | ✅ |
| admin can access users index | ✅ |
| admin can create user | ✅ |
| admin can delete user | ✅ |
| admin can access detail mahasiswa | ✅ |
| admin can update status pembayaran | ✅ |
| admin can set pemeriksaan selesai | ✅ |
| admin can access laporan | ✅ |
| admin can access rangkuman | ✅ |

---

## Bug yang Ditemukan & Diperbaiki

### 1. Loading lama saat submit formulir (FormulirController)
- **Root cause:** `x-data="{ loading: false }"` didefinisikan di dalam `<button>`, bukan di `<form>`, sehingga Alpine.js scope salah dan tombol disabled selamanya setelah diklik
- **Fix:** Pindahkan `x-data` dan `@submit="loading = true"` ke level `<form>`
- **File:** `resources/views/mahasiswa/formulir.blade.php:122`

### 2. Redundant DB query di simpan() (FormulirController)
- **Root cause:** `Faculty::find($request->fakultas)` dipanggil hanya untuk dapat nama fakultas, padahal data sudah ada di client
- **Fix:** Tambah hidden input `fakultas_nama` yang diisi JS, hapus query DB
- **File:** `app/Http/Controllers/FormulirController.php:26`

### 3. Double query di uploadBukti() (FormulirController)
- **Root cause:** Validasi `exists:pemeriksaan_kesehatans,id` + `findOrFail()` = 2 query untuk row yang sama
- **Fix:** Ganti validasi ke `required|integer`, biarkan `findOrFail()` yang handle 404
- **File:** `app/Http/Controllers/FormulirController.php:97`

### 4. POST-Redirect-GET pattern hilang (FormulirController)
- **Root cause:** `simpan()` return `view()` langsung, bukan redirect — menyebabkan re-submit jika halaman di-refresh
- **Fix:** Tambah route `GET /bayar/{id}` dan method `bayar()`, ubah `simpan()` ke `redirect()->route('bayar', $id)`
- **File:** `app/Http/Controllers/FormulirController.php:82`

### 5. Validasi tinggi/berat badan tidak ada batas
- **Root cause:** Tidak ada `min`/`max` validation, IMT bisa overflow kolom `decimal(4,2)`
- **Fix:** Tambah `min:100|max:250` untuk tinggi, `min:20|max:300` untuk berat; ubah kolom `imt` ke `decimal(5,2)`
- **File:** `app/Http/Controllers/FormulirController.php:29`, migration `2026_08_05_160311`

### 6. Required attribute di multi-step form
- **Root cause:** Field di step 1 punya `required` HTML, tapi saat user di step 3 browser tidak bisa fokus ke field step 1 yang hidden
- **Fix:** Hapus semua `required` dari HTML, validasi hanya di Laravel controller
- **File:** `resources/views/mahasiswa/formulir.blade.php`

### 7. Syntax error `<x-slot>` di view perawat & dokter
- **Root cause:** `<x-slot:name="header">` adalah sintaks yang salah, menyebabkan `array_pop() null` error
- **Fix:** Ubah ke `<x-slot name="header">`
- **File:** `resources/views/perawat/dashboard.blade.php:2`, `resources/views/dokter/dashboard.blade.php:2`

### 8. `DashboardController@update` mengirim semua field sekaligus
- **Root cause:** Update mengisi semua kolom termasuk enum (`jenis_kelamin`) dengan null, menyebabkan constraint violation di SQLite
- **Fix:** Gunakan `array_filter($request->only([...]), fn($v) => !is_null($v))` agar hanya field yang dikirim yang di-update
- **File:** `app/Http/Controllers/DashboardController.php:609`

### 9. Kolom `ishihara` dan `kesimpulan` NOT NULL saat insert dari mahasiswa
- **Root cause:** Kedua kolom diisi oleh perawat/dokter, bukan mahasiswa saat submit formulir, tapi tidak nullable
- **Fix:** Tambah migration untuk ubah keduanya menjadi nullable
- **File:** Migration `2026_08_05_164258`

---

## Index yang Ditambahkan

Migration `2026_08_05_154523`:
- `pemeriksaan_kesehatans.nim`
- `pemeriksaan_kesehatans.nik`
- `pemeriksaan_kesehatans.status_pembayaran`
- `pemeriksaan_kesehatans.status_proses`

---

## Files Baru yang Dibuat

| File | Deskripsi |
|------|-----------|
| `database/factories/PemeriksaanKesehatanFactory.php` | Factory untuk test data pemeriksaan |
| `database/factories/FacultyFactory.php` | Factory untuk test data fakultas |
| `database/factories/ProgramStudiFactory.php` | Factory untuk test data program studi |
| `tests/Feature/MahasiswaTest.php` | 12 test untuk role mahasiswa |
| `tests/Feature/PerawatTest.php` | 6 test untuk role perawat |
| `tests/Feature/DokterTest.php` | 6 test untuk role dokter |
| `tests/Feature/AdminTest.php` | 10 test untuk role admin |

---

## Cara Menjalankan Test

```bash
php artisan test
php artisan test --testsuite=Feature
php artisan test --filter=MahasiswaTest
php artisan test --filter=PerawatTest
php artisan test --filter=DokterTest
php artisan test --filter=AdminTest
```

---

## Status Octane

Laravel Octane tidak bisa diinstall di Windows native karena:
- FrankenPHP: tidak support Windows
- RoadRunner: butuh `ext-pcntl` yang tidak tersedia di Windows PHP CLI
- Swoole: tidak support Windows

**Rekomendasi:** Untuk production, deploy di Linux server dan jalankan `php artisan octane:start --server=roadrunner`

---

## Catatan untuk Session Berikutnya

- Semua 58 test sudah pass per 2026-08-05
- Jalankan `php artisan test` untuk verifikasi sebelum lanjut
- Jika ada migration baru, jalankan `php artisan migrate` untuk production DB
- View cache perlu di-clear setelah perubahan blade: `php artisan view:clear`
