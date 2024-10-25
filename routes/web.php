<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengajuanKtpController;
use App\Http\Controllers\ApproveKTPController;

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard page after login
Route::get('/dashboard', function () {
    return view('auth.dashboard');  // Pastikan ini menunjuk ke view yang benar
})->name('dashboard')->middleware('auth');

// After login, users are redirected to the KTP application form or approval list
Route::get('/pengajuan-ktp/create', [PengajuanKtpController::class, 'create'])->name('pengajuan_ktp.create')->middleware('auth');
Route::post('/pengajuan-ktp', [PengajuanKtpController::class, 'store'])->name('pengajuan_ktp.store')->middleware('auth');

// Approve page (new route)
Route::get('/pengajuan_ktp/approveList', [ApproveKTPController::class, 'approveList'])->name('pengajuan_ktp.approveList')->middleware('auth');

// Home route
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

// Routes for KTP application
Route::get('/pengajuan-ktp/{id}', [ApproveKTPController::class, 'show'])->name('pengajuan_ktp.show')->middleware('auth');
Route::post('/pengajuan-ktp/{id}/approve', [ApproveKTPController::class, 'approve'])->name('pengajuan_ktp.approve')->middleware('auth');
Route::post('/pengajuan-ktp/{id}/verify', [ApproveKTPController::class, 'verify'])->name('pengajuan_ktp.verify')->middleware('auth');
Route::post('/pengajuan-ktp/{id}/issue', [ApproveKTPController::class, 'issue'])->name('pengajuan_ktp.issue')->middleware('auth'); // New route for issue