<?php

namespace App\Jobs\EmployeeCutoff;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Services\Attendance\AttendanceServiceInterface;
use App\Models\PayrollPeriod;
use App\Helpers\Helper;
use Carbon\Carbon;

class BiMonthlySeederJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $attendanceService;
    public $helper;
    public function __construct() 
    {
        $this->attendanceService = \App::make('App\Services\Attendance\AttendanceServiceInterface');
        $this->helper = new Helper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Generate Employee Cut-off BiMonthly (BMO) started');

        // SET UP
        $frequency = PayrollPeriod::FREQUENCY_BIMONTHLY;
        $user_counts = 50;
        $payroll_period_counts = 2;
        //

        // $is_working_day = $this->helper->isDateWorkingDay(Carbon::now());
        // Log::info($is_working_day);

        $this->attendanceService->generateData($user_counts, $payroll_period_counts, $frequency);
        Log::info('Generate Employee Cut-off BiMonthly (BMO) ended');
    }
}
