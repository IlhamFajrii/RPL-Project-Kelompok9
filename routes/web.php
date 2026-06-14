<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Alat Catalog
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    
    // Alat Management - Specific routes before the general show route
    Route::middleware('admin_or_laboran')->group(function () {
        Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');
        Route::post('/alat', [AlatController::class, 'store'])->name('alat.store');
        Route::get('/alat/{alat}/edit', [AlatController::class, 'edit'])->name('alat.edit');
        Route::put('/alat/{alat}', [AlatController::class, 'update'])->name('alat.update');
        Route::delete('/alat/{alat}', [AlatController::class, 'destroy'])->name('alat.destroy');
    });
    
    // General show route - comes after specific routes
    Route::get('/alat/{alat}', [AlatController::class, 'show'])->name('alat.show');

    // Peminjaman - Protected by blacklist check
    Route::middleware('check_blacklist')->group(function () {
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{alat}/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman/{alat}', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::post('/peminjaman/{peminjaman}/upload-awal', [PeminjamanController::class, 'uploadFotoKondisiAwal'])->name('peminjaman.upload-awal');
        Route::post('/peminjaman/{peminjaman}/upload-akhir', [PeminjamanController::class, 'uploadFotoKondisiAkhir'])->name('peminjaman.upload-akhir');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });

    // QR Code
    Route::get('/qr/alat/{alat}', [QRCodeController::class, 'generateAlatQR'])->name('qr.alat');
    Route::post('/qr/scan-in/{peminjaman}', [QRCodeController::class, 'scanIn'])->name('qr.scan-in');
    Route::post('/qr/scan-out/{peminjaman}', [QRCodeController::class, 'scanOut'])->name('qr.scan-out');
    
    // Approval
    Route::middleware('admin_or_laboran')->group(function () {
        Route::get('/approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('/approval/{peminjaman}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('/approval/{peminjaman}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approval/{peminjaman}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
        Route::post('/approval/{peminjaman}/return', [ApprovalController::class, 'processReturn'])->name('approval.return');

        // Report
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::post('/report/pdf', [ReportController::class, 'generatePDF'])->name('report.pdf');
        Route::post('/report/excel', [ReportController::class, 'generateExcel'])->name('report.excel');
    });

    // Blacklist Management - Admin Only
    Route::middleware('admin')->group(function () {
        Route::get('/blacklist', [BlacklistController::class, 'index'])->name('blacklist.index');
        Route::get('/blacklist/create', [BlacklistController::class, 'create'])->name('blacklist.create');
        Route::post('/blacklist', [BlacklistController::class, 'store'])->name('blacklist.store');
        Route::get('/blacklist/{blacklist}/edit', [BlacklistController::class, 'edit'])->name('blacklist.edit');
        Route::put('/blacklist/{blacklist}', [BlacklistController::class, 'update'])->name('blacklist.update');
        Route::delete('/blacklist/{blacklist}', [BlacklistController::class, 'destroy'])->name('blacklist.destroy');
        Route::post('/blacklist/remove-expired', [BlacklistController::class, 'removeExpired'])->name('blacklist.remove-expired');
    });
});

// Auth Routes (included by default in Laravel)
require __DIR__ . '/auth.php';
