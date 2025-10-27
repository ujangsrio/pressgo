<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantAuthController;
use App\Http\Controllers\ParticipantDashboardController;
use App\Http\Controllers\ParticipantAttendanceController;
use App\Http\Controllers\ParticipantSettingController;
use App\Http\Controllers\PasswordMigrationController;
use App\Http\Controllers\LocationSettingController;

// Public routes
Route::get('/', function () {
    return redirect('/admin/login');
});

// Public scan route (bisa diakses tanpa login)
Route::get('/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
Route::post('/attendance/process', [AttendanceController::class, 'processAttendance'])->name('attendance.process');

// Admin auth routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Participant auth routes
Route::prefix('participant')->group(function () {
    Route::get('/login', [ParticipantAuthController::class, 'showLoginForm'])->name('participant.login');
    Route::post('/login', [ParticipantAuthController::class, 'login'])->name('participant.login.submit');
    Route::post('/logout', [ParticipantAuthController::class, 'logout'])->name('participant.logout');
});

// Protected admin routes - hanya bisa diakses setelah login admin
Route::middleware('admin')->group(function () {

    // Dashboard Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/data', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    });

    // Attendance Management Routes
    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::get('/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    });

    // Participant Management Routes
    Route::prefix('participants')->group(function () {
        Route::get('/', [ParticipantController::class, 'index'])->name('participants.index');
        Route::get('/create', [ParticipantController::class, 'create'])->name('participants.create');
        Route::post('/', [ParticipantController::class, 'store'])->name('participants.store');
        Route::get('/{participant}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
        Route::put('/{participant}', [ParticipantController::class, 'update'])->name('participants.update');
        Route::delete('/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');

        // Barcode & ID Card Routes
        Route::get('/{participant}/barcode-print', [ParticipantController::class, 'barcodePrint'])->name('participants.barcode-print');
        Route::get('/{participant}/id-card', [ParticipantController::class, 'idCard'])->name('participants.id-card');
        Route::get('/{participant}/id-card-print', [ParticipantController::class, 'idCardPrint'])->name('participants.id-card-print');
        Route::get('/id-cards/all', [ParticipantController::class, 'generateAllIdCards'])->name('participants.id-cards-all');

        // QR Code Routes
        Route::get('/{participant}/qr-code-print', [ParticipantController::class, 'qrCodePrint'])->name('participants.qr-code-print');
    });

    // QR Code Public Route (bisa diakses tanpa auth)
    Route::get('/qr-code/{barcodeId}', [ParticipantController::class, 'qrCode'])->name('participants.qr-code');

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/reset', [SettingController::class, 'reset'])->name('settings.reset');

        Route::post('/location', [SettingController::class, 'updateLocation'])->name('settings.location.update');
        Route::post('/location/test', [SettingController::class, 'testLocation'])->name('settings.location.test');
    });

    // Reports Routes
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
        Route::get('/participants', [ReportController::class, 'participantReport'])->name('reports.participants');
        Route::get('/export/attendance', [ReportController::class, 'exportAttendance'])->name('reports.export.attendance');
        Route::get('/export/participants', [ReportController::class, 'exportParticipants'])->name('reports.export.participants');
    });

    // Route::prefix('location-settings')->group(function () {
    //     Route::get('/', [LocationSettingController::class, 'index'])->name('location-settings.index');
    //     Route::put('/', [LocationSettingController::class, 'update'])->name('location-settings.update');
    //     Route::post('/test', [LocationSettingController::class, 'testLocation'])->name('location-settings.test');
});
// });

// Protected routes untuk peserta yang sudah login
Route::middleware('auth:participant')->prefix('participant')->group(function () {

    // Dashboard Peserta
    Route::get('/dashboard', [ParticipantDashboardController::class, 'index'])->name('participant.dashboard');

    // Attendance Routes untuk Peserta
    Route::prefix('attendance')->group(function () {
        Route::get('/scan', [ParticipantAttendanceController::class, 'scan'])->name('participant.attendance.scan');
        Route::post('/process', [ParticipantAttendanceController::class, 'processAttendance'])->name('participant.attendance.process');
        Route::get('/', [ParticipantAttendanceController::class, 'index'])->name('participant.attendance.index');
        Route::get('/{attendance}', [ParticipantAttendanceController::class, 'show'])->name('participant.attendance.show');
    });

    // Settings Routes untuk Peserta
    Route::prefix('settings')->group(function () {
        Route::get('/', [ParticipantSettingController::class, 'index'])->name('participant.settings.index');
        Route::put('/profile', [ParticipantSettingController::class, 'updateProfile'])->name('participant.settings.update-profile');
        Route::put('/password', [ParticipantSettingController::class, 'updatePassword'])->name('participant.settings.update-password');
        Route::put('/photo', [ParticipantSettingController::class, 'updatePhoto'])->name('participant.settings.update-photo');
        Route::get('/migrate-passwords', [PasswordMigrationController::class, 'migratePasswords']);
    });
});
