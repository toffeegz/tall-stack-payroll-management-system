<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Project;
use App\Models\Schedule;

use Helper; 
use Carbon\Carbon; 

class AttendanceComponent extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = "";
    public $search_project_id_table = "";

    public $search_add = "";
    public $next_page_attendance = false;

    // add attendance modal
    public array $selected_users_add_attendance = [];
    public $selected_project_add_attendance;
    public $date_add_attendance;
    public $time_in_add_attendance;
    public $time_out_add_attendance;

    public $hide = true;
    
    public function render()
    {
        return view('livewire.attendance.attendance-component',[
            'attendances' => $this->attendances,
            'users' => $this->users,
            'projects' => $this->projects,
        ])
        ->layout('layouts.app',  ['menu' => 'attendance']);
    }

    public function mount()
    {
        if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('timekeeper'))
        {
            $this->hide = false;
        }
    }

    // FETCH DATA

    public function getAttendancesProperty()
    {
        $search = $this->search;
        $selected_project_id = $this->search_project_id_table;
        if(Auth::user()->hasRole('administrator'))
        {
            $data = Attendance::leftJoin('users', 'attendances.user_id', '=', 'users.id')
            ->where(function ($query) use ($selected_project_id) {
                if($selected_project_id == "n/a")
                {
                    return $query->where('project_id', null);
                }
                elseif($selected_project_id != "")
                {
                    return $query->where('project_id', $selected_project_id);
                }
            })
            ->where(function ($query) use ($search) {
                return $query->where('users.last_name', 'like', '%' . $search . '%')
                ->orWhere('users.first_name', 'like', '%' . $search . '%')
                ->orWhere('users.code', 'like', '%' . $search . '%');
            })
            ->paginate($this->perPage);
        }
        elseif(Auth::user()->hasRole('timekeeper'))
        {
            $data = Attendance::where('created_by', Auth::user()->id)
            ->where(function ($query) use ($selected_project_id) {
                if($selected_project_id == "n/a")
                {
                    return $query->where('project_id', null);
                }
                elseif($selected_project_id != "")
                {
                    return $query->where('project_id', $selected_project_id);
                }
            })
            ->leftJoin('users', 'attendances.user_id', '=', 'users.id')
            ->where(function ($query) use ($search) {
                return $query->where('users.last_name', 'like', '%' . $search . '%')
                ->orWhere('users.first_name', 'like', '%' . $search . '%')
                ->orWhere('users.code', 'like', '%' . $search . '%');
            })
            ->orWhere('user_id', Auth::user()->id)->paginate($this->perPage);
        }
        else 
        {
            $data = Attendance::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($selected_project_id) {
                if($selected_project_id == "n/a")
                {
                    return $query->where('project_id', null);
                }
                elseif($selected_project_id != "")
                {
                    return $query->where('project_id', $selected_project_id);
                }
            })
            ->where(function ($query) use ($search) {
                return $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('time_in', 'like', '%' . $search . '%')
                ->orWhere('time_out', 'like', '%' . $search . '%');
            })
            ->paginate($this->perPage);
        }
        return $data;
    }

    public function getUsersProperty()
    {
        $search = $this->search_add;
        $data = collect([]);
        if(Auth::user()->hasRole('administrator'))
        {
            $data = User::where('employee_status', 1)
            ->where(function ($query) use ($search) {
                return $query->where('last_name', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%');
            })
            ->get();
        }
        elseif(Auth::user()->hasRole('timekeeper'))
        {
            $project = Self::getTimekeepersLatestProject();

            if($project)
            {
                $user_ids = $project->users->pluck('id');

                $data = User::where('employee_status', 1)
                ->whereIn('id', [$user_ids])
                ->where(function ($query) use ($search) {
                    return $query->where('last_name', 'like', '%' . $search . '%')
                    ->orWhere('first_name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
                })
                ->get();
            } 
            else 
            {
                // $this->hide = true;
                $data = User::where('employee_status', 1)
                ->where('id', Auth::user()->id)
                ->where(function ($query) use ($search) {
                    return $query->where('last_name', 'like', '%' . $search . '%')
                    ->orWhere('first_name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
                })
                ->get();
            }
        }
        return $data;
    }

    public function getProjectsProperty()
    {
        if(Auth::user()->hasRole('administrator'))
        {
            return Project::latest()->get();
        } else {
            return Auth::user()->projects;
        }
    }

    public function getTimekeepersLatestProject()
    {
        $project= null;
        $project_found = Helper::latestTimekeeperRecord(Auth::user()->id);
        if($project_found)
        {
            $project_id = $project_found->project_id;
            $project = Project::find($project_id);
        }
        return $project;
        
    }



    // SUBMIT
    public function submitAddAttendance()
    {
        if($this->hide == true)
        {
            // if user
            $this->validate([
                'date_add_attendance' => 'required',
                'time_in_add_attendance' => 'required',
                'time_out_add_attendance' => 'required',
            ]);

            $get_hours = Self::getHoursOfAttendance();
            dd($get_hours);
            // $new_attendance = new Attendance;
            // $new_attendance->user_id = Auth::user()->id;
            // $new_attendance->project_id = $this->selected_project_add_attendance;
            // $new_attendance->date = $this->date_add_attendance;
            // $new_attendance->time_in = $this->time_in_add_attendance;
            // $new_attendance->time_out = $this->time_out_add_attendance;
        } 
        else 
        {
            // if admin or timekeeper
            if(Auth::user()->hasRole('timekeeper'))
            {
                $project = Self::getTimekeepersLatestProject();
                if($project)
                {
                    $this->selected_project_add_attendance = $project->id;
                }
            }

            $this->validate([
                'selected_users_add_attendance' => 'required|array|min:1',
                'selected_project_add_attendance' => 'required',
                'date_add_attendance' => 'required',
                'time_in_add_attendance' => 'required',
                'time_out_add_attendance' => 'required',
            ]);
        }
        
    }


    // NEXT and BACK of Modal
    public function nextPageAttendance()
    {
        $this->next_page_attendance = true;
    }

    public function backPageAttendance()
    {
        $this->next_page_attendance = false;
    }


    // PROCESSED DATA
    public function getHoursOfAttendance()
    {
        $current_date = Carbon::now();
        $schedule = Schedule::find(1);

        $late_hours = 0;
        $undertime_hours = 0;
        $overtime_hours = 0;
        $night_differential_hours = 0;
        $regular_hours = 0;

        $lunch_hours = 0;


        // sched found
        if($schedule)
        {
            $date = Carbon::parse($this->date_add_attendance);
            $time_in = new Carbon($this->date_add_attendance . " " . $this->time_in_add_attendance);
            $time_out = new Carbon($this->date_add_attendance . " " . $this->time_out_add_attendance);

            $is_date_working_day = Helper::isDateWorkingDay($date);

            if($time_in >= $time_out)
            {
                $time_out = $time_out->addDays(1);
            }

            $schedule_in = new Carbon($this->date_add_attendance . " " . $schedule->time_in);
            $schedule_out = new Carbon($this->date_add_attendance . " " . $schedule->time_out);
            $lunch_time = Carbon::parse($this->date_add_attendance . " " . $schedule->lunch_time);

            // /////////////////

            // TOTAL RAW HOURS
                $raw_hours = $time_out->diff($time_in)->format('%H');
                $raw_minutes = $time_out->diff($time_in)->format('%i');
                $raw_hours_to_int = $raw_hours + $raw_minutes / 60;
            // 

            // LUNCH TIME DEDUCT
            if($lunch_time->between($time_in, $time_out, true))
            {
                $lunch_hours = 1;
            }
            // 

            // TOTAL WORKED HOURS
                $worked_hours = ($raw_hours + $raw_minutes / 60) - $lunch_hours;
                // $worked_minutes = Carbon::createFromFormat("H:i", ($worked_hours . ":" . $raw_minutes));
            // 


            // LATE
                if($time_in > $schedule_in)
                {
                    $late_hours_and_minutes = $schedule_in->diff($time_in)->format('%H:%i');
                    $late_hours = $schedule_in->diff($time_in)->format('%H');
                    $late_minutes = $schedule_in->diff($time_in)->format('%i');

                    if($late_minutes >= 15 && $late_hours > 0)
                    {
                        $late_hours = $late_hours + 1;
                    } elseif($late_minutes >= 15 && $late_hours == 0)
                    {
                        $late_hours = 1;
                    }
                }
            // 
            
            // UNDERTIME
                if($time_out < $schedule_out)
                {
                    $undertime_hours_and_minutes = $schedule_out->diff($time_out)->format('%H:%i');
                    $undertime_hours = $schedule_out->diff($time_out)->format('%H');
                    $undertime_minutes = $schedule_out->diff($time_out)->format('%i');
                    if($undertime_minutes >= 1 && $undertime_hours > 0)
                    {
                        $undertime_hours = $undertime_hours + 1;
                    } elseif($undertime_minutes >= 1 && $undertime_hours == 0)
                    {
                        $undertime_hours = "01";
                    }
                }
                // dd($undertime_hours);
            // 

            // OVERTIME
                if($worked_hours > 8)
                {
                    // if($raw_minutes >= 30)
                    // {
                        $overtime_hours = $worked_hours - 8;
                    // }
                }
            // 

            // NIGHT DIFFERENTIAL  
                $night_diff_start = Carbon::createFromFormat('Y-m-d H:i a', $this->date_add_attendance . ' 10:00 PM');
                
                if($time_out > $night_diff_start)
                {
                    $night_diff_hours_and_minutes = $night_diff_start->diff($time_out)->format('%H:%i');
                    $night_differential_hours = $night_diff_start->diff($time_out)->format('%H');
                    $night_diff_minutes = $night_diff_start->diff($time_out)->format('%i');
                    if($night_differential_hours == 0 && $night_diff_minutes >= 30)
                    {
                        $night_differential_hours = 1;
                    }
                    elseif($night_differential_hours > 0)
                    {
                        if($night_diff_minutes >= 45 && $night_diff_minutes <=60)
                        {
                            $night_differential_hours += .75;
                        } elseif($night_diff_minutes >= 30)
                        {
                            $night_differential_hours += .50;
                        }  elseif($night_diff_minutes >= 15)
                        {
                            $night_differential_hours += .25;
                        }
                    } else {
                        $night_differential_hours = 0;
                    }
                }
            // 

            // REGULAR HOURS
                $regular_hours = $regular_hours - $overtime_hours;
            // 

        }

        return $collection = [
            'raw' => $raw_hours_to_int,
            'regular' => $worked_hours,
            'late' => $late_hours,
            'undertime' => $undertime_hours,
            'overtime' => $overtime_hours,
            'night_differential' => $night_differential_hours,
        ];
    }

    public function getAttendanceStatus($late_hours)
    {
        $status = 0;
        if(Auth::user()->hasRole('administrator'))
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
}
