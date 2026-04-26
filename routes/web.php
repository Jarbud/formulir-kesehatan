<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;


Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/admin/mahasiswa/{id}', [DashboardController::class, 'detailMahasiswa'])->name('admin.mahasiswa.detail');
    
    // Route cetak PDF untuk Admin (menggunakan fungsi yang sama dari FormulirController)
    Route::get('/admin/cetak-formulir/{id}', [FormulirController::class, 'cetakPdf'])->name('admin.cetak.formulir');
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
