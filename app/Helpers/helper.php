<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Timekeeper;
use App\Models\Project;
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
    
}