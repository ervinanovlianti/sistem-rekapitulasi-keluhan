<?php

use App\Http\Controllers\KeluhanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaiveBayesController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/keluhan', [KeluhanController::class, 'index']);

// Route::get('/detail_keluhan', function () {
//     return view('detail_keluhan');
// });

Route::get('/pengguna-jasa', [KeluhanController::class, 'dataPenggunaJasa']);
Route::get('/cs', [KeluhanController::class, 'dataCS']);

Route::get('/input_keluhan', [KeluhanController::class, 'showInputForm']);
Route::post('/input_keluhan', [KeluhanController::class, 'store']);
Route::get('/input_datacs', [NaiveBayesController::class, 'formInputDataCs']);
Route::post('/input_datacs', [NaiveBayesController::class, 'inputDataCs']);

Route::get('/laporan', [KeluhanController::class, 'index']);

Route::get('/rekapitulasi', function () {
    return view('rekapitulasi');
});
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