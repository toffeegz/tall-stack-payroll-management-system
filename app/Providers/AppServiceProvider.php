<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\AttendanceServiceInterface;

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
