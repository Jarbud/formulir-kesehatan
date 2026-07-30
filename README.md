# Formulir Pemeriksaan Kesehatan

Sistem informasi pemeriksaan kesehatan mahasiswa baru Universitas Negeri Malang. Aplikasi ini mengelola alur pemeriksaan kesehatan dari pengisian formulir oleh mahasiswa hingga pencetakan dokumen resmi oleh admin.

## Fitur

### Mahasiswa
- Mengisi formulir data diri & riwayat kesehatan
- Menghitung IMT otomatis (Tinggi Badan & Berat Badan)
- Upload bukti pembayaran
- Melihat riwayat pemeriksaan & cetak PDF

### Perawat
- Input data pemeriksaan: Tekanan Darah, Ishihara Test, Lingkar Perut, Gula Darah, Visus Mata
- Export data ke CSV/Excel
- Cetak formulir PDF

### Dokter
- Input kesimpulan (Layak / Layak dengan Syarat / Tidak Layak)
- Input rekomendasi
- Export data ke CSV/Excel
- Cetak formulir PDF

### Admin
- Dashboard ringkasan per fakultas & prodi
- Edit lengkap seluruh data pemeriksaan
- Tanda tangan digital (TTD) dengan QR Code
- Laporan export dengan filter (fakultas, prodi, harian, bulanan, tahunan)
- Rangkuman kinerja perawat & dokter
- Manajemen user (CRUD)

## Data Pemeriksaan

| Field | Input Oleh |
|-------|-----------|
| Tekanan Darah (mmHg) | Perawat |
| Ishihara Test (+/-/Parsial) | Perawat |
| Lingkar Perut (cm) | Perawat |
| Gula Darah (mg/dL) | Perawat |
| Visus Mata (Normal/Gangguan) | Perawat |
| Kesimpulan | Dokter |
| Rekomendasi | Dokter |
| TTD & QR Code | Admin |

## Tech Stack

- **Framework:** Laravel 11
- **Frontend:** Blade + Tailwind CSS
- **PDF:** barryvdh/laravel-dompdf
- **QR Code:** simplesoftwareio/simple-qrcode
- **Database:** MySQL
- **Auth:** Laravel Breeze

## Instalasi

```bash
git clone https://github.com/Jarbud/formulir-kesehatan.git
cd formulir-kesehatan
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

## Struktur Role

| Role | Akses |
|------|-------|
| `mahasiswa` | Isi formulir, riwayat, cetak PDF |
| `perawat` | Input pemeriksaan, export, cetak PDF |
| `dokter` | Input kesimpulan & rekomendasi, export, cetak PDF |
| `admin` | Full akses, edit, TTD, laporan, manajemen user |

## License

MIT License
