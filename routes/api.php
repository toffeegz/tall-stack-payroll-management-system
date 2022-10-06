<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Http\Controllers\Api\HelperController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('generate-code/{key}', function($key) {
        $year = Carbon::now()->format('Y');
        $data = $year . "-" . sprintf('%04d', $key);
        return $data;
    });
});

Route::get('/generate-payroll-period', [HelperController::class, 'generatePayrollPeriod']);

