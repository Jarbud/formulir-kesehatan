<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\Perawat\DashboardController as PerawatDashboardController;
use App\Http\Controllers\Perawat\FormulirController as PerawatFormulirController;
use App\Http\Controllers\Dokter\DashboardController as DokterDashboardController;
use App\Http\Controllers\Dokter\FormulirController as DokterFormulirController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Route untuk validasi QR Code Nakes (Public)
Route::get('/validasi-nakes/{id}', [DashboardController::class, 'validasiNakes'])->name('validasi.nakes');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk Admin
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/fakultas/{fakultas}', [DashboardController::class, 'prodiByFakultas'])->name('admin.fakultas.prodi');
    Route::get('/admin/fakultas/{fakultas}/prodi/{prodi}', [DashboardController::class, 'mahasiswaByProdi'])->name('admin.prodi.mahasiswa');
    Route::get('/admin/mahasiswa/{id}', [DashboardController::class, 'detailMahasiswa'])->name('admin.mahasiswa.detail');
    Route::put('/admin/pemeriksaan/{id}', [DashboardController::class, 'update'])->name('admin.pemeriksaan.update');

    // Route cetak PDF untuk Admin (menggunakan fungsi yang sama dari FormulirController)
    Route::get('/admin/cetak-formulir/{id}', [FormulirController::class, 'cetakPdf'])->name('admin.cetak.formulir');
    Route::get('/admin/export-excel/{id}', [DashboardController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/admin/export-excel-all', [DashboardController::class, 'exportExcelAll'])->name('admin.export.excel.all');
    Route::put('/admin/pemeriksaan/{id}/ttd', [DashboardController::class, 'ttdPemeriksaan'])->name('admin.pemeriksaan.ttd');
    
    Route::get('/admin/laporan', [DashboardController::class, 'laporanIndex'])->name('admin.laporan.index');
    Route::post('/admin/laporan/export', [DashboardController::class, 'exportLaporan'])->name('admin.laporan.export');
    Route::post('/admin/laporan/export-pdf', [DashboardController::class, 'exportLaporanPdf'])->name('admin.laporan.export_pdf');
    Route::post('/admin/laporan/reset-export', [DashboardController::class, 'resetExportStatus'])->name('admin.laporan.reset_export');
    Route::get('/admin/rangkuman', [DashboardController::class, 'rangkumanPemeriksaan'])->name('admin.rangkuman');
    Route::get('/admin/rangkuman/export-all', [DashboardController::class, 'exportKinerjaAll'])->name('admin.rangkuman.export_all');
    Route::get('/admin/rangkuman/export/{role}/{id}', [DashboardController::class, 'exportKinerjaDetails'])->name('admin.rangkuman.export');
    Route::post('/admin/rangkuman/export-excel', [DashboardController::class, 'exportRangkumanExcel'])->name('admin.rangkuman.export_excel');
    Route::post('/admin/rangkuman/export-pdf', [DashboardController::class, 'exportRangkumanPdf'])->name('admin.rangkuman.export_pdf');

    // CRUD Akun Users
    Route::resource('/admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

// Route untuk Perawat
Route::middleware(['auth', 'checkRole:perawat'])->group(function () {
    Route::get('/perawat/dashboard', [PerawatDashboardController::class, 'adminDashboard'])->name('perawat.dashboard');
    Route::get('/perawat/fakultas/{fakultas}', [PerawatDashboardController::class, 'mahasiswaByFakultas'])->name('perawat.fakultas.mahasiswa');
    Route::get('/perawat/mahasiswa/{id}', [PerawatDashboardController::class, 'detailMahasiswa'])->name('perawat.mahasiswa.detail');
    
    Route::get('/perawat/cetak-formulir/{id}', [PerawatFormulirController::class, 'cetakPdf'])->name('perawat.cetak.formulir');
    Route::get('/perawat/export-excel/{id}', [PerawatDashboardController::class, 'exportExcel'])->name('perawat.export.excel');
    Route::get('/perawat/export-excel-all', [PerawatDashboardController::class, 'exportExcelAll'])->name('perawat.export.excel.all');
    Route::put('/perawat/pemeriksaan/{id}', [PerawatDashboardController::class, 'updatePemeriksaan'])->name('perawat.pemeriksaan.update');
});

// Route untuk Dokter
Route::middleware(['auth', 'checkRole:dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterDashboardController::class, 'adminDashboard'])->name('dokter.dashboard');
    Route::get('/dokter/fakultas/{fakultas}', [DokterDashboardController::class, 'mahasiswaByFakultas'])->name('dokter.fakultas.mahasiswa');
    Route::get('/dokter/mahasiswa/{id}', [DokterDashboardController::class, 'detailMahasiswa'])->name('dokter.mahasiswa.detail');
    
    Route::get('/dokter/cetak-formulir/{id}', [DokterFormulirController::class, 'cetakPdf'])->name('dokter.cetak.formulir');
    Route::get('/dokter/export-excel/{id}', [DokterDashboardController::class, 'exportExcel'])->name('dokter.export.excel');
    Route::get('/dokter/export-excel-all', [DokterDashboardController::class, 'exportExcelAll'])->name('dokter.export.excel.all');
    Route::put('/dokter/pemeriksaan/{id}', [DokterDashboardController::class, 'updatePemeriksaan'])->name('dokter.pemeriksaan.update');
});

// Route untuk Mahasiswa
Route::middleware(['auth', 'checkRole:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    Route::get('/formulir', [FormulirController::class, 'index'])->name('formulir');
    Route::post('/simpan-data', [FormulirController::class, 'simpan'])->name('simpan-data');
    Route::post('/upload-bukti', [FormulirController::class, 'uploadBukti'])->name('upload-bukti');
    Route::get('/riwayat', [FormulirController::class, 'riwayat'])->name('riwayat');
    // Sesuaikan nama controller dan parameternya (misal menggunakan ID mahasiswa)
    Route::get('/cetak-formulir/{id}', [FormulirController::class, 'cetakPdf'])->name('cetak.formulir');
});

// Ganti dengan ini:
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/auth.php';
