<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::group(['namespace' => 'App\Http\Livewire'], function() {
        Route::get('/', function () {
            return redirect()->route('dashboard');
        });
        Route::get('dashboard', Dashboard\DashboardComponent::class)->name('dashboard');

        Route::get('attendance', Attendance\AttendanceComponent::class)->name('attendance');

        // Administrator
        Route::group(['middleware' => ['auth', 'role:administrator']], function() {

            // Payroll
            Route::group(['namespace' => 'Payroll'], function() {
                Route::get('payroll', PayrollComponent::class)->name('payroll');
                // Route::get('payroll/settings', Settings\PayrollSettingsComponent::class)->name('payroll.settings');

                Route::get('payroll/run', RunPayrollComponent::class)->name('payroll.run');
            });
        });
    });
    
});

require __DIR__.'/auth.php';
