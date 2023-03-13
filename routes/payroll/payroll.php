<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payslip\PayslipController;


Route::prefix('payslips')->group(function() {
    Route::get('{id}', [PayslipController::class, 'show'])->name('payroll.payslip');
});
