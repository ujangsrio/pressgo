<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return redirect('/admin/login');
});


Route::get('/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
Route::post('/attendance/process', [AttendanceController::class, 'processAttendance'])->name('attendance.process');

// Admin auth routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Protected admin routes - hanya bisa diakses setelah login
Route::middleware('admin')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');




    // Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    // Participant Management Routes
    // Route::resource('participants', ParticipantController::class);

    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::get('/participants/{participant}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
    Route::put('/participants/{participant}', [ParticipantController::class, 'update'])->name('participants.update');
    Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
    Route::get('/participants/{participant}/barcode-print', [ParticipantController::class, 'barcodePrint'])->name('participants.barcode-print');
    Route::get('/participants/{participant}/id-card', [ParticipantController::class, 'idCard'])->name('participants.id-card');
    Route::get('/participants/{participant}/id-card-print', [ParticipantController::class, 'idCardPrint'])->name('participants.id-card-print');
    Route::get('/participants/id-cards/all', [ParticipantController::class, 'generateAllIdCards'])->name('participants.id-cards-all');

    // QR Code Routes
    Route::get('/participants/{participant}/qr-code-print', [ParticipantController::class, 'qrCodePrint'])
        ->name('participants.qr-code-print');
    Route::get('/qr-code/{barcodeId}', [ParticipantController::class, 'qrCode'])
        ->name('participants.qr-code');

    // Settings Route
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingController::class, 'reset'])->name('settings.reset');

    // Reports Routes
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
        Route::get('/participants', [ReportController::class, 'participantReport'])->name('reports.participants');
        Route::get('/export/attendance', [ReportController::class, 'exportAttendance'])->name('reports.export.attendance');
        Route::get('/export/participants', [ReportController::class, 'exportParticipants'])->name('reports.export.participants');
    });
});
