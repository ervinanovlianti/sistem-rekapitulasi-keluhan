<?php

use App\Http\Controllers\KeluhanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaiveBayesController;

Route::get('/', [KeluhanController::class, 'dashboard']);
Route::get('/keluhan', [KeluhanController::class, 'index']);

Route::get('/pengguna-jasa', [KeluhanController::class, 'dataPenggunaJasa']);
Route::get('/cs', [KeluhanController::class, 'dataCS']);

Route::get('/input_keluhan', [KeluhanController::class, 'showInputForm']);
Route::post('/input_keluhan', [KeluhanController::class, 'store']);
Route::get('/input_datacs', [KeluhanController::class, 'formInputDataCS']);
Route::post('/input-datacs', [KeluhanController::class, 'inputDataCS']);

Route::get('/laporan', [KeluhanController::class, 'laporan']);
Route::get('/rekapitulasi', [KeluhanController::class, 'index']);
Route::get('/profil', function () {
    return view('profil');
});

Route::get('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
Route::post('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);

Route::get('/detail-keluhan/{id}', [KeluhanController::class, 'detailKeluhan']);
Route::get('/verifikasi-keluhan/{id}', [KeluhanController::class, 'verifikasiKeluhan']);
Route::get('/terima-keluhan/{id}', [KeluhanController::class, 'terimaKeluhan']);
Route::get('/keluhan-selesai/{id}', [KeluhanController::class, 'keluhanSelesai']);

Route::get('/dashboard-cs', function () {
    return view('cs.dashboard_cs');
});
Route::get('/dashboard-pj', function () {
    return view('pengguna_jasa.dashboard_pj');
});

// Route untuk menyimpan hasil klasifikasi ke dalam database
Route::post('/simpan-ke-database', [NaiveBayesController::class, 'saveDataToDatabase']);