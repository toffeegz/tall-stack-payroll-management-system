<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Timekeeper;
use App\Models\Project;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use DatePeriod;
use DateInterval;



class Helper
{
    // ///////////////////// DATE HELPER

    public static function getRangeBetweenDates($period_start, $period_end)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $period_start);
        $end_date = Carbon::createFromFormat('Y-m-d', $period_end);
  
        $dateRange = CarbonPeriod::create($start_date, $end_date);
   
        return $dateRange->toArray();
    }

    public static function getRangeBetweenDatesStr($period_start, $period_end)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $period_start);
        $end_date = Carbon::createFromFormat('Y-m-d', $period_end);
  
        $dateRange = CarbonPeriod::create($start_date, $end_date);;

        $dates = [];
        // Iterate over the period
        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Convert the period to an array of dates
        return $dates;
    }
    public static function isDateWorkingDay($date)
    {
        // return boolean
        $bool_str = null;
        $schedule = Schedule::find(1);
        if($schedule)
        {
            $day = strtolower($date->format('l'));
            $working_days = json_decode($schedule->working_days, true);
            $bool_str = $working_days[$day];
        }
        return $bool_str;
    }

    

    // ///////////////////// ATTENDANCE

    public static function getProjectName($id)
    {
        $name = "N/A";
        $project = Project::find($id);
        if($project)
        {
            $name = $project->name;
        }
        return $name;
    }
    

    // EMPLOYEE
    public static function latestTimekeeperRecord($user_id)
    {
        return DB::table('timekeepers')->where('user_id', $user_id)->latest()->first();
    }

    // LOAN
    public static function getCashAdvanceAmountToPay($user_id)
    {
        $loans = Self::loanAutoDeduct($user_id);

        $balance_from_previous = 0;
        $installment_amount = 0;
        foreach($loans as $loan)
        {
            $loan_installments = LoanInstallment::where('loan_id', $loan->id)->get();
            $balance_from_previous += $loan_installments->sum('balance');
            $balance_from_previous += $loan->installment_amount;
        }

        $total_amount_to_pay = $installment_amount + $balance_from_previous;
        return $total_amount_to_pay;
    }

    public static function loanAutoDeduct($user_id)
    {
        return Loan::where('user_id', $user_id)
        ->where('status', 2)
        ->where('auto_deduct', true)
        ->where('balance', '!=', 0)
        ->get();
    }
    
}