<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PimpinanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi Pelayanan Rumah Sunat Elnara
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/edukasi', [HomeController::class, 'edukasi'])->name('edukasi');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');

Route::get('/daftar', [PendaftaranController::class, 'create'])->name('daftar');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('daftar.store');

Route::get('/tiket/{no_registrasi}', [PendaftaranController::class, 'tiket'])->name('tiket');
Route::post('/tiket/{no_registrasi}/upload-bukti', [PendaftaranController::class, 'uploadBukti'])->name('tiket.upload_bukti');

Route::get('/cek-antrean', [AntreanController::class, 'cekAntrean'])->name('cek_antrean');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Protected Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.index');

    Route::get('/pendaftaran', [AdminController::class, 'pendaftaran'])->name('pendaftaran');
    Route::post('/pendaftaran/{id}/verifikasi-dp', [AdminController::class, 'verifikasiDp'])->name('pendaftaran.verifikasi_dp');
    Route::post('/pendaftaran/{id}/pelunasan', [AdminController::class, 'pelunasan'])->name('pendaftaran.pelunasan');

    Route::get('/antrean', [AdminController::class, 'antrean'])->name('antrean');
    Route::get('/antrean/{id}/panggil', [AdminController::class, 'panggilAntrean'])->name('antrean.panggil');

    Route::get('/paket', [AdminController::class, 'paket'])->name('paket');
    Route::post('/paket', [AdminController::class, 'storePaket'])->name('paket.store');
    Route::post('/paket/{id}/update', [AdminController::class, 'updatePaket'])->name('paket.update');
    Route::get('/paket/{id}/toggle', [AdminController::class, 'togglePaket'])->name('paket.toggle');

    Route::get('/pasien', [AdminController::class, 'pasien'])->name('pasien');
    Route::get('/dokter', [AdminController::class, 'dokter'])->name('dokter');
    Route::get('/dokter/{id}/toggle', [AdminController::class, 'toggleDokter'])->name('dokter.toggle');

    Route::get('/kirim-wa', [AdminController::class, 'kirimWa'])->name('kirim_wa');
    Route::post('/kirim-wa', [AdminController::class, 'storeWa'])->name('kirim_wa.store');

    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
});

// Protected Dokter Routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard.index');

    Route::get('/antrean', [DokterController::class, 'antrean'])->name('antrean');
    Route::get('/rekam-medis/{id_pendaftaran}', [DokterController::class, 'rekamMedis'])->name('rekam_medis');
    Route::post('/rekam-medis/{id_pendaftaran}', [DokterController::class, 'storeRekamMedis'])->name('rekam_medis.store');
    Route::get('/rekam-medis/{id_pendaftaran}/cetak', [DokterController::class, 'cetakRme'])->name('rekam_medis.cetak');
});

// Protected Pimpinan Routes
Route::middleware(['auth', 'role:pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/', [PimpinanController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('dashboard.index');
    Route::get('/laporan', [PimpinanController::class, 'laporan'])->name('laporan');
});
