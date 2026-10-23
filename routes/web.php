<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\EnsureAdminAuthenticated;
use Illuminate\Support\Facades\Route;

/* ═══════════════════════════ PUBLIC ═══════════════════════════ */
Route::get('/', [RegistrationController::class, 'home'])->name('home');
Route::post('/daftar', [RegistrationController::class, 'store'])
    ->name('registration.store')
    ->middleware('throttle:10,1');
Route::get('/sukses/{kode}', [RegistrationController::class, 'success'])->name('registration.success');
Route::get('/cek-tiket', [RegistrationController::class, 'ticketLookup'])
    ->name('registration.lookup')
    ->middleware('throttle:20,1');

/* ═══════════════════════════ ADMIN ════════════════════════════ */
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginProcess'])
    ->name('admin.login.process')
    ->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(EnsureAdminAuthenticated::class)->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/peserta/{registration}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/export', [AdminController::class, 'exportCsv'])->name('admin.export');
    Route::get('/admin/info', [AdminController::class, 'info'])->name('admin.info');
});
