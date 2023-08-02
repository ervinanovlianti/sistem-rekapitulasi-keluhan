<?php

use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaiveBayesController;

Route::get('/wel', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'login')->name('login')->middleware('guest');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    // Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
Route::middleware(['auth', 'hak_akses:admin'])->group(function () {
    Route::get('/dashboard', [KeluhanController::class, 'dashboard'])->name('dashboard');
    Route::get('/keluhan', [KeluhanController::class, 'index']);
    Route::get('/input_keluhan', [KeluhanController::class, 'showInputForm']);
    Route::get('/pengguna-jasa', [KeluhanController::class, 'dataPenggunaJasa']);
    Route::get('/detail-penggunajasa/{id}', [KeluhanController::class, 'detailPenggunaJasa']);
    Route::get('/input_datacs', [KeluhanController::class, 'formInputDataCS']);
    Route::post('/input-datacs', [KeluhanController::class, 'inputDataCS']);
    Route::get('/import-data', [KeluhanController::class, 'formImportData']);
    Route::post('/import-data', [KeluhanController::class, 'importData']);
    Route::get('/laporan', [KeluhanController::class, 'laporan'])->name('laporan');
    Route::get('/laporan', [KeluhanController::class , 'cari'])->name('laporan.cari');
    Route::get('/rekapitulasi', [KeluhanController::class, 'rekapitulasi']);
    Route::get('/notifikasi', [KeluhanController::class, 'notifikasi']);
    Route::get('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/simpan-ke-database', [NaiveBayesController::class, 'saveDataToDatabase']);

    Route::get('/detail-keluhan/{id}', [KeluhanController::class, 'detailKeluhan']);
    Route::post('/verifikasi-keluhan', [KeluhanController::class, 'verifikasiKeluhan']);
    Route::get('/terima-keluhan/{id}', [KeluhanController::class, 'terimaKeluhan']);
    Route::post('/konfirmasi-selesai', [KeluhanController::class, 'keluhanSelesai']);

    Route::get('/cs', [KeluhanController::class, 'dataCS'])->middleware('auth');
    Route::get('/profil', function () {
        return view('profil');
    });

});
Route::middleware(['auth', 'hak_akses:pengguna_jasa'])->group(function () {
    Route::get('/dashboard-pj', function () {
        return view('pengguna_jasa.dashboard_pj');
    })->name('dashboard-pj');
});
Route::middleware(['auth', 'hak_akses:cs'])->group(function () {
    Route::get('/dashboard-cs', function () {
        return view('cs.dashboard_cs');
    })->name('dashboard-cs');
});



