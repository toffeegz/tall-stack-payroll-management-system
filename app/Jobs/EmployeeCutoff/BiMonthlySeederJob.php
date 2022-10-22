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
use App\Models\User;
use App\Models\Schedule;
use Carbon\Carbon;
use Helper;

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
        $generate_leaves = true;
        $frequency = PayrollPeriod::FREQUENCY_BIMONTHLY;

        // schedule
        $default_schedule = Schedule::find(Schedule::DEFAULT);
        $time_in = $default_schedule->time_in;
        $time_out = $default_schedule->time_out;
        
       
        // users
        $user_counts = 2;
        $users = User::where('frequency_id', $frequency)->whereNull('deleted_at')->take($user_counts)->get();

        // payroll periods
        $payroll_period_counts = 1;
        $payroll_periods = PayrollPeriod::where('frequency_id', $frequency)
        ->whereNull('deleted_at')
        ->where('is_payroll_generated', false)
        ->latest('payout_date')
        ->take($payroll_period_counts)
        ->get();

        $working_days = [];
        foreach($payroll_periods as $payroll_period) {
            $period_start = $payroll_period->period_start;
            $period_end = $payroll_period->period_end;

            $date_ranges = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);
            
            foreach($date_ranges as $date) {
                $is_working_day = $this->helper->isDateWorkingDay(Carbon::parse($date));
                foreach($users as $user)
                {
                    $absent_chance = $this->helper->randomWithChance($chance = 1);
                    $late_chance = $this->helper->randomWithChance($chance = 5);
                    $overtime_chance = $this->helper->randomWithChance($chance = 20);

                    if($late_chance == true) {
                        // $time_in = minus ka between 15min to 1.2h
                    }
                    if($overtime_chance == true) {
                        // $time_out = add ka between 1hr to 3hrs
                    }

                    if($is_working_day) {
                        // $working_days[] =  Carbon::parse($date)->format('Y-m-d');
                        if($absent_chance == false) {
                            $attendance = $this->attendanceService->store($user->id, $project_id = null, $date, $time_in, $time_out);
                        } 
                        
                    } else {
                        $dayoff_ot_chance = $this->helper->randomWithChance($chance = 10);
                        if($dayoff_ot_chance == true) {
    
                        }
                    }
                }
                
            }
        }
        // Log::info($working_days);
        Log::info('Generate Employee Cut-off BiMonthly (BMO) ended');
    }
}
