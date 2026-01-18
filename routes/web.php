<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Redirect ke login saat akses root
Route::get('/', function () {
    return redirect('/admin/dashboard');
})->name('home');

// Welcome page (optional, bisa diakses dari menu)
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Attendance Routes (QR code scan - accessible without login)
Route::get('/absen/{token}', [AttendanceController::class, 'handleQRCode'])
    ->name('attendance.form');
Route::post('/absen/{token}', [AttendanceController::class, 'store'])
    ->name('attendance.store');
Route::get('/absen/edit/{id}', [AttendanceController::class, 'edit'])
    ->name('attendance.edit');
Route::put('/absen/{id}', [AttendanceController::class, 'update'])
    ->name('attendance.update');
Route::delete('/absen/{id}', [AttendanceController::class, 'destroy'])
    ->name('attendance.destroy');

// Admin Routes (No auth required)
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Sessions Management
    Route::get('/sessions', [AdminController::class, 'sessions'])
        ->name('sessions');
    Route::get('/sessions/create', [AdminController::class, 'createSession'])
        ->name('createSession');
    Route::post('/sessions', [AdminController::class, 'storeSession'])
        ->name('storeSession');
    Route::get('/sessions/{id}', [AdminController::class, 'showSession'])
        ->name('sessions.show');
    Route::get('/sessions/{id}/qrcode', [AdminController::class, 'generateQRCode'])
        ->name('generateQRCode');
    Route::get('/sessions/{id}/export', [AdminController::class, 'exportAttendance'])
        ->name('exportAttendance');
    Route::delete('/sessions/{id}', [AdminController::class, 'deleteSession'])
        ->name('deleteSession');
});

require __DIR__.'/auth.php';
