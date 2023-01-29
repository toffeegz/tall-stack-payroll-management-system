<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use App\Models\CompanyInformation;
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

    public static function getRangeMonthBetweenDates($period_start, $period_end)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $period_start);
        $end_date = Carbon::createFromFormat('Y-m-d', $period_end);

        $dateRange = CarbonPeriod::create($start_date, '1 month', $end_date);
        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date;
        }
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

    public static function getHoursDurationWorkingDay($period_start, $period_end)
    {
        $date_range = Helper::getRangeBetweenDates($period_start, $period_end);

        $hours_duration = 0;
        foreach($date_range as $date)
        {
            $is_date_working_day = Helper::isDateWorkingDay($date);
            if($is_date_working_day)
            {
                $hours_duration += 8;
            }
        }

        return $hours_duration;

    }

    // COMPANY INFORMATION
    
    public static function getCompanyInformation()
    {
        return CompanyInformation::find(1);
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
        $loans = Loan::where('user_id', $user_id)
        ->where('status', 2)
        ->where('auto_deduct', true)
        ->where('balance', '!=', 0)
        ->get();

        $total_amount_to_pay = 0;
        foreach($loans as $loan)
        {
            $total_amount_to_pay += $loan->pay_next;
        }
        return $total_amount_to_pay;
    }

    ////////////// // GENERATOR


    public static function generateCode($value)
    {
        // $year = Carbon::now()->format('Y');
        $year = '2022';
        $data = $year . "-" . sprintf('%04d', $value);
        return $data;
    }

    public static function randomWithChance($chance)
    {
        // chance in percentage
        $random = round(mt_rand(1, (1 / $chance) * 100));
        return $random == 1 ? true:false;
    }
    
}