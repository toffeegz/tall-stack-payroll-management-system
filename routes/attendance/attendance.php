<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Attendance\AttendanceController;


Route::prefix('attendances-custom')->group(function() {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('{user}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::put('{user}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('{user}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
});

// Route::resource('attendances-custom', AttendanceController::class);