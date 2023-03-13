<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;

use App\Repositories\Attendance\AttendanceRepository;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Holiday\HolidayRepository;
use App\Repositories\Holiday\HolidayRepositoryInterface;
use App\Repositories\Leave\LeaveRepository;
use App\Repositories\Leave\LeaveRepositoryInterface;
use App\Repositories\LeaveType\LeaveTypeRepository;
use App\Repositories\LeaveType\LeaveTypeRepositoryInterface;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\Loan\LoanRepositoryInterface;
use App\Repositories\LoanInstallment\LoanInstallmentRepository;
use App\Repositories\LoanInstallment\LoanInstallmentRepositoryInterface;
use App\Repositories\PayrollLog\PayrollLogRepository;
use App\Repositories\PayrollLog\PayrollLogRepositoryInterface;
use App\Repositories\PayrollPeriod\PayrollPeriodRepository;
use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use App\Repositories\Payslip\PayslipRepository;
use App\Repositories\Payslip\PayslipRepositoryInterface;
use App\Repositories\PhicContributionRate\PhicContributionRateRepository;
use App\Repositories\PhicContributionRate\PhicContributionRateRepositoryInterface;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Schedule\ScheduleRepository;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Repositories\SssContribution\SssContributionRepository;
use App\Repositories\SssContribution\SssContributionRepositoryInterface;
use App\Repositories\SssContributionRate\SssContributionRateRepository;
use App\Repositories\SssContributionRate\SssContributionRateRepositoryInterface;
use App\Repositories\Timekeeper\TimekeeperRepository;
use App\Repositories\Timekeeper\TimekeeperRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(HolidayRepositoryInterface::class, HolidayRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, LeaveRepository::class);
        $this->app->bind(LeaveTypeRepositoryInterface::class, LeaveTypeRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(LoanInstallmentRepositoryInterface::class, LoanInstallmentRepository::class);
        $this->app->bind(PayrollLogRepositoryInterface::class, PayrollLogRepository::class);
        $this->app->bind(PayrollPeriodRepositoryInterface::class, PayrollPeriodRepository::class);
        $this->app->bind(PayslipRepositoryInterface::class, PayslipRepository::class);
        $this->app->bind(PhicContributionRateRepositoryInterface::class, PhicContributionRateRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(SssContributionRepositoryInterface::class, SssContributionRepository::class);
        $this->app->bind(SssContributionRateRepositoryInterface::class, SssContributionRateRepository::class);
        $this->app->bind(TimekeeperRepositoryInterface::class, TimekeeperRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
