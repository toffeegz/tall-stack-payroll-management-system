<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Attendance\AttendanceService;
use App\Services\Attendance\AttendanceServiceInterface;
use App\Services\PayrollPeriod\PayrollPeriodService;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Services\Project\ProjectService;
use App\Services\Project\ProjectServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use App\Services\Utils\FileService;
use App\Services\Utils\FileServiceInterface;
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
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(FileServiceInterface::class, FileService::class);
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
