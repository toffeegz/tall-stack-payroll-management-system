<?php

namespace App\Services\Attendance;
use App\Services\Attendance\AttendanceServiceInterface;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Helper;

use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Models\Schedule;
use App\Models\PayrollPeriod;
use App\Models\User;

class AttendanceService implements AttendanceServiceInterface
{
    private AttendanceRepositoryInterface $modelRepository;
    public $helper;

    public function __construct(
        AttendanceRepositoryInterface $modelRepository,
        UserRepositoryInterface $userRepository,
        ProjectRepositoryInterface $projectRepository,
        ScheduleRepositoryInterface $scheduleRepository,
    ) {
        $this->modelRepository = $modelRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->helper = new Helper;
    }

    public function store($user_id, $project_id, $date, $time_in, $time_out)
    {
        // $is_admin = false;
        // if(Auth::user()->hasRole('administrator')) {
        //     $is_admin = true;
        // }
        // is_admin true if data generated
        $is_admin = true;

        $user = $this->userRepository->show($user_id);
        $selected_project_id = null;
        if($project_id) {
            $project = $this->projectRepository->show($project_id);
            $selected_project_id = $project->id;
        }

        $get_hours = $this->getHoursAttendance($date, $time_in, $time_out);
        $get_status = $this->getAttendanceStatus($date, $get_hours['late'], $is_admin);

        $result = $this->modelRepository->updateOrCreate([
            'user_id' => $user->id,
            'date' => $date,
        ], [
            'time_in' => Carbon::parse($time_in)->format('h:i'),
            'time_out' => Carbon::parse($time_out)->format('h:i'),
            'regular' => $get_hours['regular'],
            'late' => $get_hours['late'],
            'undertime' => $get_hours['undertime'],
            'overtime' => $get_hours['overtime'],
            'night_differential' => $get_hours['night_differential'],
            'status' => $get_status,
            'project_id' => $selected_project_id,
        ]);

        return $result;
    }

    public function getHoursAttendance($date_attendance, $time_in_attendance, $time_out_attendance)
    {
        $current_date = Carbon::now();
        $schedule = $this->scheduleRepository->show(Schedule::DEFAULT);
        
        $late = 0;
        $undertime = 0;
        $overtime = 0;
        $night_differential = 0;
        $regular = 0;

        $lunch_hours = 0;

        $date = Carbon::parse($date_attendance);
        $time_in = new Carbon($date_attendance . " " . $time_in_attendance);
        $time_out = new Carbon($date_attendance . " " . $time_out_attendance);

        $is_date_working_day = Helper::isDateWorkingDay($date);

        if($time_in >= $time_out)
        {
            $time_out = $time_out->addDays(1);
        }

        $schedule_in = new Carbon($date_attendance . " " . $schedule->time_in);
        $schedule_out = new Carbon($date_attendance . " " . $schedule->time_out);
        $lunch_time = Carbon::parse($date_attendance . " " . $schedule->lunch_time);

        // /////////////////

        $approved_time_in = Carbon::createFromFormat("Y-m-d H:i", $date_attendance . " " . $time_in->format('H') .":00");
        $approved_time_out = Carbon::createFromFormat("Y-m-d H:i", $date_attendance . " " . $time_out->format('H:i'));
        
        // LATE
            if($time_in > $schedule_in)
            {
                $late_hours_and_minutes = $schedule_in->diff($time_in)->format('%H:%i');
                $late_minutes = $schedule_in->diff($time_in)->format('%i');
                $late_hours = $schedule_in->diff($time_in)->format('%H');

                if($late_minutes >= 15)
                {
                    $approved_time_in = $approved_time_in->addHour();
                } 
                $late = (int)$approved_time_in->diff($schedule_in)->format('%H');
            }
            
        // 

        // UNDERTIME
            if($time_out < $schedule_out)
            {
                $approved_time_out = Carbon::createFromFormat("Y-m-d H:i", $date_attendance . " " . $time_out->format('H') . ":00");
                $undertime = (int)$schedule_out->diff($approved_time_out)->format('%H');
            }
        // 

        // APPROVED HOURS
            $approved_hours = $approved_time_in->diff($approved_time_out)->format('%H');
            $approved_mins = $approved_time_in->diff($approved_time_out)->format('%i');
            $approved = $approved_hours + ($approved_mins / 60);
            $total_hours_worked = $approved;
        // 

        // LUNCH TIME DEDUCT
            if($lunch_time->between($approved_time_in, $approved_time_out, true))
            {
                $total_hours_worked -= 1;
            }
        // 

        $regular = $total_hours_worked;

        // OVERTIME
            if($total_hours_worked > 8)
            {
                $overtime_value = $total_hours_worked - 8;
                $overtime = floor($overtime_value);      // 1
                $fraction = $overtime_value - $overtime;

                if($fraction >= .5)
                {
                    $overtime += 1;
                }
                $regular = $total_hours_worked - $overtime;
                $regular = $regular - $fraction;
            }
        // 

        // NIGHT DIFFERENTIAL  
            $night_diff_start = Carbon::createFromFormat('Y-m-d H:i a', $date_attendance . ' 10:00 PM');
            
            if($approved_time_out > $night_diff_start)
            {
                $night_diff_hours_and_minutes = $night_diff_start->diff($approved_time_out)->format('%H:%i');
                $night_differential = $night_diff_start->diff($approved_time_out)->format('%H');
                $night_diff_minutes = $night_diff_start->diff($approved_time_out)->format('%i');
                if($night_differential == 0 && $night_diff_minutes >= 30)
                {
                    $night_differential = 1;
                }
                elseif($night_differential > 0)
                {
                    if($night_diff_minutes >= 45 && $night_diff_minutes <=60)
                    {
                        $night_differential += .75;
                    } elseif($night_diff_minutes >= 30)
                    {
                        $night_differential += .50;
                    }  elseif($night_diff_minutes >= 15)
                    {
                        $night_differential += .25;
                    }
                } else {
                    $night_differential = 0;
                }
            }
        // 


        return $collection = [
            'regular' => $regular,
            'late' => $late,
            'undertime' => $undertime,
            'overtime' => $overtime,
            'night_differential' => $night_differential,
        ];
    }

    public function getAttendanceStatus($date, $late_hours, $is_admin)
    {
        $date = Carbon::parse($date);
        $is_date_working_day = Helper::isDateWorkingDay($date);
        $status = 0;
        if($is_admin == true)
        {
            
            if($is_date_working_day == true)
            {
                $status = 1; // PRESENT

                if($late_hours > 0)
                {
                    $status = 2;  // LATE
                }
            } 
            else 
            {
                $status = 3; // RESTDAY 
            }
        }
        else
        {
            $status = 4; // PENDING 
        }
        return $status;
    }



    // DATA GENERATOR
    public function generateData($user_counts, $payroll_period_counts, $frequency)
    {
        // schedule
        $default_schedule = Schedule::find(Schedule::DEFAULT);
        $time_in = $default_schedule->time_in;
        $time_out = $default_schedule->time_out;
        
        // users
        $users = User::where('frequency_id', $frequency)
        ->whereNull('deleted_at')
        ->take($user_counts)
        ->get();

        // payroll periods
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
                    $time_in = $default_schedule->time_in;
                    $time_out = $default_schedule->time_out;

                    $absent_chance = $this->helper->randomWithChance($chance = 3);
                    $late_chance = $this->helper->randomWithChance($chance = 5);
                    $overtime_chance = $this->helper->randomWithChance($chance = 40);
                    $dayoff_ot_chance = $this->helper->randomWithChance($chance = 10);

                    $is_present = true;
            
                    if($is_working_day == true) {
                        if($absent_chance == true) {
                            $is_present = false;
                        } else {
                            if($late_chance == true) {
                                $late_minutes = rand(5,75);
                                $time_in = Carbon::createFromFormat('H:i:s', $time_in)->addMinutes($late_minutes)->format('H:i:s');
                            }
                            if($overtime_chance == true) {
                                $overtime_minutes = rand(5, 120);
                                $time_out = Carbon::createFromFormat('H:i:s', $time_out)->addMinutes($overtime_minutes)->format('H:i:s');
                            }
                        }
                    } else {
                        $is_present = false;
                        if($dayoff_ot_chance == true) {
                            $is_present = true;
                        }
                    }

                    if($is_present == true) {
                        $result = $this->store($user->id, null, $date, $time_in, $time_out);
                    }
                }

            }
        }

    }
}