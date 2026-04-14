<?php

use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');

    // Nilai Mata Kuliah (NEW)
    Route::get('/nilai', [\App\Http\Controllers\NilaiMahasiswaController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [\App\Http\Controllers\NilaiMahasiswaController::class, 'store'])->name('nilai.store');
    Route::post('/nilai/calculate', [\App\Http\Controllers\NilaiMahasiswaController::class, 'calculate'])->name('nilai.calculate');

    // Penilaian Kriteria Tambahan (Skill, Minat, Sertifikasi)
    Route::get('/penilaian-kriteria', [\App\Http\Controllers\PenilaianKriteriaController::class, 'create'])->name('penilaian-kriteria.create');
    Route::post('/penilaian-kriteria', [\App\Http\Controllers\PenilaianKriteriaController::class, 'store'])->name('penilaian-kriteria.store');
    Route::post('/penilaian-kriteria/calculate', [\App\Http\Controllers\PenilaianKriteriaController::class, 'calculate'])->name('penilaian-kriteria.calculate');

    // Penilaian (OLD - akan dihapus nanti)
    Route::get('/penilaian', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::post('/penilaian/calculate', [PenilaianController::class, 'calculate'])->name('penilaian.calculate');

    // Hasil Rekomendasi
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/detail', [HasilController::class, 'detail'])->name('hasil.detail');

    // Admin Routes
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('alternatif', AlternatifController::class);
    });
});

require __DIR__.'/auth.php';
