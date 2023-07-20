<?php

use App\Http\Controllers\KeluhanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NaiveBayesController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/keluhan', [NaiveBayesController::class, 'index']);

Route::get('/detail_keluhan', function () {
    return view('detail_keluhan');
});

Route::get('/pelanggan', function () {
    return view('data_pelanggan');
});
Route::get('/cs', function () {
    return view('data_cs');
});

Route::get('/input_keluhan', [KeluhanController::class, 'showInputForm']);
Route::post('/input_keluhan', [KeluhanController::class, 'store']);

Route::get('/input_datacs', function () {
    return view('input_datacs');
});
Route::get('/laporan', [KeluhanController::class, 'index']);

Route::get('/rekapitulasi', function () {
    return view('rekapitulasi');
});
Route::get('/profil', function () {
    return view('profil');
});

Route::get('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);
Route::post('/perhitungan-naive-bayes', [NaiveBayesController::class, 'preprocessing']);