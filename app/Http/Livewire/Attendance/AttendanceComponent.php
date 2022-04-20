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

    public $perPage = 5;
    public $search = "";
    public $search_project_id_table = "";

    public $search_add = "";
    public $next_page_attendance = false;

    // add attendance modal
    public array $selected_users_add_attendance = [];
    public $selected_project_add_attendance = "";
    public $date_add_attendance;
    public $time_in_add_attendance;
    public $time_out_add_attendance;

    // approve attendance modal
    public array $selected_attendance_approve_attendance = [];
    public $search_name_or_date_approve_attendance = "";
    public $selected_status_approve_attendance = 1;

    // attendance details modal
    public $selected_details_status;
    public $selected_details_status_name;
    public $selected_details_date;
    public $selected_details_time_in;
    public $selected_details_time_out;
    public $selected_details_project_id;
    public $selected_details_id;

    public $hide = true;
    
    public array $logs = [];
    public $added_count = 0;
    public $updated_count = 0;

    public function render()
    {
        return view('livewire.attendance.attendance-component',[
            'attendances' => $this->attendances,
            'users' => $this->users,
            'projects' => $this->projects,
            'pending_attendances' => $this->pending_attendances,
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
                ->orWhere('users.code', 'like', '%' . $search . '%')
                ->orWhere('attendances.date', 'like', '%' . $search . '%')
                ->orWhere('attendances.time_in', 'like', '%' . $search . '%')
                ->orWhere('attendances.time_out', 'like', '%' . $search . '%');
                
            })
            ->latest('attendances.updated_at')
            ->select('attendances.*', 'users.first_name', 'users.last_name', 'users.code', 'users.profile_photo_path')
            ->paginate($this->perPage);
        }
        elseif(Auth::user()->hasRole('timekeeper'))
        {
            $data = Attendance::where('created_by', Auth::user()->id)
            ->where(function ($query) use ($selected_project_id) {
                if($selected_project_id == "n/a")
                {
                    return $query->whereNull('project_id');
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
                ->orWhere('users.code', 'like', '%' . $search . '%')
                ->orWhere('attendances.date', 'like', '%' . $search . '%')
                ->orWhere('attendances.time_in', 'like', '%' . $search . '%')
                ->orWhere('attendances.time_out', 'like', '%' . $search . '%');
            })
            ->latest('attendances.updated_at')
            ->select('attendances.*', 'users.first_name', 'users.last_name', 'users.code', 'users.profile_photo_path')
            ->paginate($this->perPage);
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
            ->latest('updated_at')
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

    public function getPendingAttendancesProperty()
    {
        $search = $this->search_name_or_date_approve_attendance;
        return Attendance::leftJoin('users', 'attendances.user_id', '=', 'users.id')
        ->where(function ($query) use ($search) {
            return $query->where('users.last_name', 'like', '%' . $search . '%')
            ->orWhere('users.first_name', 'like', '%' . $search . '%')
            ->orWhere('users.code', 'like', '%' . $search . '%')
            ->orWhere('attendances.date', 'like', '%' . $search . '%');
        })
        ->select('attendances.id', 'users.last_name', 'users.first_name', 'users.code', 'attendances.date', 'users.profile_photo_path')
        ->where('attendances.status', 4)
        ->paginate(10);
    }



    // SUBMIT
    public function submitAddAttendance()
    {
        $this->logs = [];
        $this->updated_count = 0;
        $this->added_count = 0;
        if($this->hide == true)
        {
            // if user
            $this->validate([
                'date_add_attendance' => 'required',
                'time_in_add_attendance' => 'required',
                'time_out_add_attendance' => 'required',
            ]);

            $get_hours = Self::getHoursAttendance($this->date_add_attendance, $this->time_in_add_attendance, $this->time_out_add_attendance);
            $get_status = Self::getAttendanceStatus($this->date_add_attendance, $get_hours['late']);

            $data = [
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->formal_name(),
                'date' => $this->date_add_attendance,
                'time_in' => $this->time_in_add_attendance,
                'time_out' => $this->time_out_add_attendance,
                'regular' => $get_hours['regular'],
                'late' => $get_hours['late'],
                'undertime' => $get_hours['undertime'],
                'overtime' => $get_hours['overtime'],
                'night_differential' => $get_hours['night_differential'],
                'status' => $get_status,
                'project_id' => $this->selected_project_add_attendance,
            ];

            Self::insertAttendance($data);
            
        } 
        else 
        {
            // if admin or timekeeper
            if(Auth::user()->hasRole('timekeeper'))
            {
                $project = Self::getTimekeepersLatestProject(Auth::user()->id);
                if($project)
                {
                    $this->selected_project_add_attendance = $project->id;
                }

                $this->validate([
                    'selected_users_add_attendance' => 'required|array|min:1',
                    'selected_project_add_attendance' => 'required',
                    'date_add_attendance' => 'required',
                    'time_in_add_attendance' => 'required',
                    'time_out_add_attendance' => 'required',
                ]);
            } else 
            {
                $this->validate([
                    'selected_users_add_attendance' => 'required|array|min:1',
                    'date_add_attendance' => 'required',
                    'time_in_add_attendance' => 'required',
                    'time_out_add_attendance' => 'required',
                ]);
            }

            

            $get_hours = Self::getHoursAttendance($this->date_add_attendance, $this->time_in_add_attendance, $this->time_out_add_attendance);
            $get_status = Self::getAttendanceStatus($this->date_add_attendance, $get_hours['late']);

            foreach($this->selected_users_add_attendance as $user_id)
            {
                $user_name = "";
                $user = User::find($user_id);
                if($user)
                {
                    $user_name = $user->informal_name();
                }
                

                $data = [
                    'user_name' => $user_name,
                    'user_id' => $user_id,
                    'date' => $this->date_add_attendance,
                    'time_in' => $this->time_in_add_attendance,
                    'time_out' => $this->time_out_add_attendance,
                    'regular' => $get_hours['regular'],
                    'late' => $get_hours['late'],
                    'undertime' => $get_hours['undertime'],
                    'overtime' => $get_hours['overtime'],
                    'night_differential' => $get_hours['night_differential'],
                    'status' => $get_status,
                    'project_id' => $this->selected_project_add_attendance,
                ];
    
                Self::insertAttendance($data);
            }
        }
        
        $this->emit('closeAddAttendanceModal');
        $this->emit('openNotifModal');
    }

    public function submitApproveAttendance()
    {
        foreach($this->selected_attendance_approve_attendance as $attendance_id)
        {
            $status = $this->selected_status_approve_attendance;

            $update_attendance = Attendance::find($attendance_id);
            $date = $update_attendance->date;

            if($this->selected_status_approve_attendance != 5)
            {
                $status = Self::getAttendanceStatus($date, $update_attendance->late);
            }

            $update_attendance->status = $status;
            $update_attendance->save();
        }
        $this->emit('closeApproveAttendanceModal');
    }

    public function updateAttendanceDetails()
    {
        $update_attendance = Attendance::find($this->selected_details_id);

        $updated_hours = Self::getHoursAttendance($this->selected_details_date, $this->selected_details_time_in, $this->selected_details_time_out);
        $update_attendance->regular = $updated_hours['regular'];
        $update_attendance->late = $updated_hours['late'];
        $update_attendance->undertime = $updated_hours['undertime'];
        $update_attendance->overtime = $updated_hours['overtime'];
        $update_attendance->night_differential = $updated_hours['night_differential'];

        $status = $this->selected_details_status;
        if(Auth::user()->hasRole('administrator')) {
            if($status == 1)
            {
                $date = $this->selected_details_date;
                $status = Self::getAttendanceStatus($date, $updated_hours['late']);
            }
        } else {
            $status = 4;
        }
        
        $update_attendance->status = $status;
        $update_attendance->date = $this->selected_details_date;
        $update_attendance->time_in = $this->selected_details_time_in;
        $update_attendance->time_out = $this->selected_details_time_out;
        $update_attendance->project_id = $this->selected_details_project_id;

        $update_attendance->save();
        $this->emit('closeAttendanceDetailsModal');
    }


    public function openAttendanceDetails($id)
    {
        $attendance = Attendance::find($id);
        $status = $attendance->status;
        if($status != 4 && $status != 5)
        {
            $status = 1;
        }
        $this->selected_details_status = $status;
        $this->selected_details_date = $attendance->date;
        $this->selected_details_time_in = $attendance->time_in;
        $this->selected_details_time_out = $attendance->time_out;
        $this->selected_details_project_id = $attendance->project_id;
        $this->selected_details_id = $attendance->id;
        switch($attendance->status)
        {
            case 1:
                $this->selected_details_status_name = 'Present';
                break;
            case 2:
                $this->selected_details_status_name = 'Late';
                break;
            case 3:
                $this->selected_details_status_name = 'No sched';
                break;
            case 4:
                $this->selected_details_status_name = 'Pending';
                break;
            case 5:
                $this->selected_details_status_name = 'Disapproved';
        }
        $this->emit('openAttendanceDetailsModal');
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

        $late = 0;
        $undertime = 0;
        $overtime = 0;
        $night_differential = 0;
        $regular = 0;

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

                $approved_time_in = Carbon::createFromFormat("Y-m-d H:i", $this->date_add_attendance . " " . $time_in->format('H') .":00");
                $approved_time_out = Carbon::createFromFormat("Y-m-d H:i", $this->date_add_attendance . " " . $time_out->format('H:i'));
                
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
                        $approved_time_out = Carbon::createFromFormat("Y-m-d H:i", $this->date_add_attendance . " " . $time_out->format('H') . ":00");
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
                    $night_diff_start = Carbon::createFromFormat('Y-m-d H:i a', $this->date_add_attendance . ' 10:00 PM');
                    
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

        }

        return $collection = [
            'regular' => $regular,
            'late' => $late,
            'undertime' => $undertime,
            'overtime' => $overtime,
            'night_differential' => $night_differential,
        ];
    }

    public function getHoursAttendance($date_attendance, $time_in_attendance, $time_out_attendance)
    {
        $current_date = Carbon::now();
        $schedule = Schedule::find(1);

        $late = 0;
        $undertime = 0;
        $overtime = 0;
        $night_differential = 0;
        $regular = 0;

        $lunch_hours = 0;


        // sched found
        if($schedule)
        {
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

        }

        return $collection = [
            'regular' => $regular,
            'late' => $late,
            'undertime' => $undertime,
            'overtime' => $overtime,
            'night_differential' => $night_differential,
        ];
    }

    public function getAttendanceStatus($date, $late_hours)
    {
        $date = Carbon::parse($date);
        $is_date_working_day = Helper::isDateWorkingDay($date);
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

    // INSERT
    public function insertAttendance($data)
    {
        $new_attendance = Attendance::where('date', $data['date'])->where('user_id', $data['user_id'])->first();
        if($new_attendance)
        {
            $this->logs['Updated'][] = $data['user_name'];
            $this->updated_count =+ 1;
        }
        else
        {
            $this->logs['Added'][] = $data['user_name'];
            $this->added_count =+ 1;
            $new_attendance = new Attendance;
        }
        $new_attendance->user_id = $data['user_id'];
        $new_attendance->date = $data['date'];
        $new_attendance->time_in = $data['time_in'];
        $new_attendance->time_out = $data['time_out'];
        $new_attendance->regular = $data['regular'];
        $new_attendance->late = $data['late'];
        $new_attendance->undertime = $data['undertime'];
        $new_attendance->overtime = $data['overtime'];
        $new_attendance->night_differential = $data['night_differential'];
        $new_attendance->status = $data['status'];
        $new_attendance->project_id = $data['project_id'] ? $data['project_id'] : null;
        $new_attendance->created_by = Auth::user()->id;
        $new_attendance->save();
    }

}
