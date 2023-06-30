<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/template', function () {
    return view('template');
});
Route::get('/keluhan', function () {
    return view('data_keluhan');
});
Route::get('/detail_keluhan', function () {
    return view('detail_keluhan');
});
Route::get('/pelanggan', function () {
    return view('data_pelanggan');
});
Route::get('/cs', function () {
    return view('data_cs');
});
Route::get('/input_data', function () {
    return view('input_keluhan');
});
Route::get('/laporan', function () {
    return view('laporan');
});
Route::get('/rekapitulasi', function () {
    return view('rekapitulasi');
});
Route::get('/profil', function () {
    return view('profil');
});
