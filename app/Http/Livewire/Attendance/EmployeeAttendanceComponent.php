<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Services\Attendance\AttendanceServiceInterface;
use App\Services\Utils\FileServiceInterface;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

use App\Imports\AttendanceImport;
use App\Exports\Attendance\AttendanceExport;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Project;
use App\Models\Schedule;

use Helper; 
use Carbon\Carbon; 

class EmployeeAttendanceComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $auth_user;
    public $notif_message = null;

    public $perPage = 5;
    public $search = "";
    public $search_project_id = "";

    // today
    public $todays_attendance;

    // add attendance modal
    public $project_id = null;
    public $date;
    public $time_in;
    public $time_out;
    public $selected_id;
    public $status_id;
    public $hide = true;

    private AttendanceServiceInterface $modelService;
    private AttendanceRepositoryInterface $modelRepository;

    public function boot(
        AttendanceServiceInterface $service,
        AttendanceRepositoryInterface $modelRepository,
        UserRepositoryInterface $userRepository,
    ) {
        $this->modelService = $service;
        $this->modelRepository = $modelRepository;
    }

    public function render() 
    {
        return view('livewire.attendance.employee-attendance-component',[
            'data' => $this->data,
            'projects' => $this->projects,
        ])
        ->layout('layouts.app',  ['menu' => 'attendance']);
    }

    public function mount() 
    {
        $this->auth_user = Auth::user();
        $this->todays_attendance = $this->modelRepository->today();
    }
    
    // FETCH DATA

    public function getDataProperty()
    {
        $data = $this->modelRepository->index($this->search, $this->search_project_id, $this->perPage);
        return $data;
    }

    public function getProjectsProperty()
    {
        return $this->auth_user->projects;
    }

    public function create()
    {
        if($this->project_id) {
            $this->validate([
                'project_id' => 'required'
            ]);
        }

        $data = [
            'user_id' => $this->auth_user->id,
            'project_id' => $this->project_id,
        ];

        $data = $this->modelService->create($data);
        $this->todays_attendance = $this->modelRepository->today();
        $this->emit('closeAddAttendanceModal');
        // $this->notif_message = "not import";
        $this->emit('openNotifModal');
    }

    public function updateAttendanceDetails()
    {
        // $update_attendance = $this->modelRepository->show($this->selected_id);

        // $updated_hours = $this->modelService->getHoursAttendance($this->selected_details_date, $this->selected_details_time_in, $this->selected_details_time_out);
        // $update_attendance->regular = $updated_hours['regular'];
        // $update_attendance->late = $updated_hours['late'];
        // $update_attendance->undertime = $updated_hours['undertime'];
        // $update_attendance->overtime = $updated_hours['overtime'];
        // $update_attendance->night_differential = $updated_hours['night_differential'];

        // $status = $this->selected_details_status;
        // if(Auth::user()->hasRole('administrator')) {
        //     if($status == 1)
        //     {
        //         $date = $this->selected_details_date;
        //         $status = $this->modelService->getAttendanceStatus($date, $updated_hours['late']);
        //     }
        // } else {
        //     $status = 4;
        // }
        
        // $update_attendance->status = $status;
        // $update_attendance->date = $this->selected_details_date;
        // $update_attendance->time_in = $this->selected_details_time_in;
        // $update_attendance->time_out = $this->selected_details_time_out;
        // $update_attendance->project_id = $this->selected_details_project_id;

        // $update_attendance->save();
        // $this->emit('closeAttendanceDetailsModal');
    }


    public function openAttendanceDetails($id)
    {
        // $attendance = Attendance::find($id);
        // $status = $attendance->status;
        // if($status != 4 && $status != 5)
        // {
        //     $status = 1;
        // }
        // $this->selected_details_status = $status;
        // $this->selected_details_date = $attendance->date;
        // $this->selected_details_time_in = $attendance->time_in;
        // $this->selected_details_time_out = $attendance->time_out;
        // $this->selected_details_project_id = $attendance->project_id;
        // $this->selected_details_id = $attendance->id;
        // switch($attendance->status)
        // {
        //     case 1:
        //         $this->selected_details_status_name = 'Present';
        //         break;
        //     case 2:
        //         $this->selected_details_status_name = 'Late';
        //         break;
        //     case 3:
        //         $this->selected_details_status_name = 'No sched';
        //         break;
        //     case 4:
        //         $this->selected_details_status_name = 'Pending';
        //         break;
        //     case 5:
        //         $this->selected_details_status_name = 'Disapproved';
        // }
        // $this->emit('openAttendanceDetailsModal');
    }

    // INSERT
    public function insertAttendance($data)
    {

    }

    public function deleteAttendance()
    {
        
    }

}
