<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- SISWA ROUTES ---
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::resource('penanaman', \App\Http\Controllers\PenanamanController::class);
        Route::resource('pemeliharaan', \App\Http\Controllers\PemeliharaanController::class);
        Route::resource('panen', \App\Http\Controllers\PanenController::class)->only(['index', 'store']);
        Route::get('evaluasi', [\App\Http\Controllers\EvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('evaluasi/penanaman/{penanaman}', [\App\Http\Controllers\EvaluasiController::class, 'show'])->name('evaluasi.show');
        Route::get('dokumentasi', function () { return view('siswa.dokumentasi'); })->name('dokumentasi');
    });

    // --- GURU ROUTES ---
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::resource('penanaman', \App\Http\Controllers\PenanamanController::class);
        Route::resource('pemeliharaan', \App\Http\Controllers\PemeliharaanController::class);
        Route::resource('panen', \App\Http\Controllers\PanenController::class)->only(['index']);
        Route::get('evaluasi', [\App\Http\Controllers\EvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('evaluasi/penanaman/{penanaman}', [\App\Http\Controllers\EvaluasiController::class, 'show'])->name('evaluasi.show');
        Route::post('evaluasi/proses', [\App\Http\Controllers\EvaluasiController::class, 'proses'])->name('evaluasi.proses');
        Route::resource('jenis_tanaman', \App\Http\Controllers\JenisTanamanController::class);
        Route::get('dokumentasi', function () { return view('guru.dokumentasi'); })->name('dokumentasi');
    });

    // --- ADMIN ROUTES ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('pengguna', \App\Http\Controllers\UserController::class);
        Route::get('evaluasi', [\App\Http\Controllers\EvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('evaluasi/penanaman/{penanaman}', [\App\Http\Controllers\EvaluasiController::class, 'show'])->name('evaluasi.show');
        Route::resource('panen', \App\Http\Controllers\PanenController::class)->only(['index']);
        Route::resource('jenis_tanaman', \App\Http\Controllers\JenisTanamanController::class);
        Route::get('dokumentasi', function () { return view('guru.dokumentasi'); })->name('dokumentasi');
    });
});

require __DIR__.'/auth.php';
