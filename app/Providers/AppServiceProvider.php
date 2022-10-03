<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Services\PayrollPeriod\PayrollPeriodService;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AttendanceServiceInterface::class, AttendanceService::class);
        $this->app->bind(PayrollPeriodServiceInterface::class, PayrollPeriodService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
