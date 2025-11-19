<?php

use App\Http\Controllers\AdminController;
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
    Route::post('/logout', 'logout')->name('logout');
});
Route::middleware(['auth', 'hak_akses:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/complaints', [AdminController::class, 'index']);
    Route::get('/complaint-form', [AdminController::class, 'showInputForm']);
    Route::get('/service-users', [AdminController::class, 'serviceUsers']);
    Route::get('/service-users/{id}', [AdminController::class, 'serviceUserDetail']);
    Route::get('/customer-service/form', [AdminController::class, 'showCustomerServiceForm']);
    Route::post('/customer-service/store', [AdminController::class, 'storeCustomerService']);
    Route::get('/import-data', [AdminController::class, 'showImportForm']);
    Route::post('/import-data', [AdminController::class, 'importComplaints']);
    Route::get('/export-to-pdf', [AdminController::class, 'exportToPDF'])->name('export-to-pdf');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/search', [AdminController::class, 'searchReports'])->name('reports.search');
    Route::get('/recapitulation', [AdminController::class, 'recapitulate']);
    Route::get('/notifications', [AdminController::class, 'notifications']);
    Route::get('/naive-bayes-calculation', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/naive-bayes-calculation', [NaiveBayesController::class, 'preprocessing']);
    Route::post('/save-to-database', [NaiveBayesController::class, 'saveDataToDatabase']);
    Route::get('/complaints/{id}/detail', [AdminController::class, 'complaintDetail']);
    Route::post('/complaints/verify', [AdminController::class, 'verifyComplaint']);
    Route::get('/complaints/{id}/accept', [AdminController::class, 'acceptComplaint']);
    Route::post('/complaints/complete', [AdminController::class, 'completeComplaint']);
    Route::get('/customer-service', [AdminController::class, 'customerServiceData'])->middleware('auth');
});

Route::middleware(['auth', 'hak_akses:pengguna_jasa'])->group(function () {
    Route::get('/service-user/dashboard', [UsersController::class, 'dashboard'])->name('service-user.dashboard');
    Route::get('/service-user/complaints', [UsersController::class, 'index']);
    Route::get('/service-user/complaint-form', [UsersController::class, 'showComplaintForm']);
    Route::post('/service-user/complaints', [UsersController::class, 'storeComplaint']);
});

Route::middleware(['auth', 'hak_akses:customer_service'])->group(function () {
    Route::get('/customer-service/dashboard', [CSController::class, 'dashboard'])
        ->name('customer-service.dashboard');
    Route::get('/customer-service/complaints', [CSController::class, 'index'])
        ->name('customer-service.complaints');
});

Route::get('/complaint-detail/{id}', [AdminController::class, 'complaintDetail']);
Route::post('/verify-complaint', [AdminController::class, 'verifyComplaint']);
Route::get('/accept-complaint/{id}', [AdminController::class, 'acceptComplaint']);
Route::post('/complete-complaint', [AdminController::class, 'completeComplaint']);

Route::get('/profil', function () {
    return view('profil');
})->middleware('auth');

Route::get('/export', [AdminController::class, 'exportComplaints'])->name('export');
