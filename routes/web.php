<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CSController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaiveBayesController;


Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'register')->name('register')->middleware('guest');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'login')->name('login')->middleware('guest');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    // Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});
Route::middleware(['auth', 'hak_akses:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/keluhan', [AdminController::class, 'index']);
    Route::get('/input_keluhan', [AdminController::class, 'showInputForm']);
    Route::get('/pengguna-jasa', [AdminController::class, 'dataPenggunaJasa']);
    Route::get('/detail-penggunajasa/{id}', [AdminController::class, 'detailPenggunaJasa']);
    Route::get('/input_datacs', [AdminController::class, 'formInputDataCS']);
    Route::post('/input-datacs', [AdminController::class, 'inputDataCS']);
    Route::get('/import-data', [AdminController::class, 'formImportData']);
    Route::post('/import-data', [AdminController::class, 'importKeluhan']);
    Route::get('/export-to-pdf', [AdminController::class, 'exportToPDF'])->name('export-to-pdf');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::get('/laporan', [AdminController::class , 'cari'])->name('laporan.cari');
    Route::get('/rekapitulasi', [AdminController::class, 'rekapitulasi']);
    // Route::post('/rekapitulasi', [AdminController::class, 'rekapitulasi']);
    Route::get('/notifikasi', [AdminController::class, 'notifikasi']);
    Route::get('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/simpan-ke-database', [NaiveBayesController::class, 'saveDataToDatabase']);

    Route::get('/detail-keluhan/{id}', [AdminController::class, 'detailKeluhan']);
    Route::post('/verifikasi-keluhan', [AdminController::class, 'verifikasiKeluhan']);
    Route::get('/terima-keluhan/{id}', [AdminController::class, 'terimaKeluhan']);
    Route::post('/konfirmasi-selesai', [AdminController::class, 'keluhanSelesai']);

    Route::get('/cs', [AdminController::class, 'dataCS'])->middleware('auth');
    
});

Route::middleware(['auth', 'hak_akses:pengguna_jasa'])->group(function () {
    Route::get('/dashboard-pj', [UsersController::class, 'dashboard'])->name('dashboard-pj');
    Route::get('/data-keluhan', [UsersController::class, 'index']);
    Route::get('/input-keluhan', [UsersController::class, 'formInput']);
    Route::post('/simpan', [UsersController::class, 'inputKeluhan']);
});
Route::middleware(['auth', 'hak_akses:customer_service'])->group(function () {
    Route::get('/dashboard-cs',[CSController::class, 'dashboard'])->name('dashboard-cs');
    Route::get('/datakeluhan',[CSController::class, 'index'])->name('datakeluhan');
});
// Route::middleware(['auth', 'hak_akses:customer_service, admin'])->group(function () {

    Route::get('/detail-keluhan/{id}', [AdminController::class, 'detailKeluhan']);
    Route::post('/verifikasi-keluhan', [AdminController::class, 'verifikasiKeluhan']);
    Route::get('/terima-keluhan/{id}', [AdminController::class, 'terimaKeluhan']);
    Route::post('/konfirmasi-selesai', [AdminController::class, 'keluhanSelesai']);
    // });

    Route::get('/profil', function () {
        return view('profil');
    })->middleware('auth');

Route::get('/export', [AdminController::class, 'exportKeluhan'])->name('export');