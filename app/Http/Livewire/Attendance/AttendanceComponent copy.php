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

            Self::getOtherDataBeforeSubmissionOfAttendance();
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
    public function getOtherDataBeforeSubmissionOfAttendance()
    {
        $current_date = Carbon::now();
        $schedule = Schedule::find(1);
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

            if($is_date_working_day == true)
            {
                // SCHEDULE TRUE
                $schedule_in = new Carbon($this->date_add_attendance . " " . $schedule->time_in);
                $schedule_out = new Carbon($this->date_add_attendance . " " . $schedule->time_out);
                $lunch_time = Carbon::parse($this->date_add_attendance . " " . $schedule->lunch_time);

                // /////////////////
    
                    // TOTAL WORKING HOURS
                        $total_working_hours = $time_out->diff($time_in)->format('%H:%I');
                    // 
    
                    // LATE
                        $late_hours = 0;
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
                                $late_hours = "01";
                            }
                        }
                        // dd($late_hours);
                    // 

                    // UNDERTIME
                        $undertime_hours = 0;
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
                        $early_overtime_hours = 0;
                        if($time_in < $schedule_in)
                        {
                            $early_overtime_hours_and_minutes = $time_in->diff($schedule_in)->format('%H:%i');
                            $early_overtime_hours = $time_in->diff($schedule_in)->format('%H');
                            $early_overtime_minutes = $time_in->diff($schedule_in)->format('%i');
                            // if($early_overtime_minutes >= 15 && $early_overtime_hours > 0)
                            // {
                            //     // if($early_overtime_minutes >= 45) {
                            //     //     $early_overtime_hours += .75;
                            //     // } elseif($early_overtime_minutes >= 30) {
                            //     //     $early_overtime_hours += .50;
                            //     // }
                            //     // elseif($early_overtime_minutes >= 15) {
                            //     //     $early_overtime_hours += .25;
                            //     // }
                            //     if($early_overtime_minutes >= 30) {
                            //         $early_overtime_hours += 1;
                            //     }
                            // } elseif($early_overtime_minutes >= 15 && $early_overtime_hours == 0)
                            // {
                            //     // if($early_overtime_minutes >= 45) {
                            //     //     $early_overtime_hours = .75;
                            //     // } elseif($early_overtime_minutes >= 30) {
                            //     //     $early_overtime_hours = .50;
                            //     // }
                            //     // elseif($early_overtime_minutes >= 15) {
                            //     //     $early_overtime_hours = .25;
                            //     // }
                            //     if($early_overtime_minutes >= 30) {
                            //         $early_overtime_hours += 1;
                            //     }
                            // }
                            if($early_overtime_minutes >= 30)
                            {
                                $early_overtime_hours += 1;
                            }
                        }

                        $overtime_hours = 0;
                        if($time_out > $schedule_out)
                        {
                            $overtime_hours_and_minutes = $time_out->diff($schedule_out)->format('%H:%i');
                            $overtime_hours = $time_out->diff($schedule_out)->format('%H');
                            $overtime_minutes = $time_out->diff($schedule_out)->format('%i');
                            // if($overtime_hours > 0)
                            // {
                            //     // if($overtime_minutes >= 45) {
                            //     //     $overtime_hours += .75;
                            //     // } elseif($overtime_minutes >= 30) {
                            //     //     $overtime_hours += .50;
                            //     // }
                            //     // elseif($overtime_minutes >= 15) {
                            //     //     $overtime_hours += .25;
                            //     // }
                            //         $overtime_hours += $overtime_hours;
                            // // } elseif($overtime_minutes >= 30 && $overtime_hours == 0)
                            // } 
                            if($overtime_minutes >= 30)
                            {
                                // if($overtime_minutes >= 45) {
                                //     $overtime_hours = .75;
                                // } elseif($overtime_minutes >= 30) {
                                //     $overtime_hours = .50;
                                // }
                                // elseif($overtime_minutes >= 15) {
                                //     $overtime_hours = .25;
                                // }
                                if($overtime_minutes >= 30) {
                                    $overtime_hours += 1;
                                }
                            }
                        }

                        $overtime_hours = $overtime_hours + $early_overtime_hours;
                        // dd($overtime_hours);
                    // 
                // 
            }
            // NIGHT DIFFERENTIAL
                $night_diff_hours = 0;
                            
                $night_diff_start = Carbon::createFromFormat('Y-m-d H:i a', $this->date_add_attendance . ' 10:00 PM');
                
                if($time_out > $night_diff_start)
                {
                    $night_diff_hours_and_minutes = $night_diff_start->diff($time_out)->format('%H:%i');
                    $night_diff_hours = $night_diff_start->diff($time_out)->format('%H');
                    $night_diff_minutes = $night_diff_start->diff($time_out)->format('%i');
                    if($night_diff_minutes >= 30)
                    {
                        $night_diff_hours += 1;
                    }
                }
                dd($night_diff_hours);
            // // 
            
        }

    }
}
