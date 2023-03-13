<?php

namespace App\Http\Livewire\Leave;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Leave\UserLeaveHistoryExport;
use App\Exports\Leave\LeaveHistoryExport;

use App\Models\User;
use App\Models\Leave;
use App\Models\LeaveType;
use Helper;
use Carbon\Carbon;


class LeaveComponent extends Component
{


    // create
    public $user_id = null;
    public $type = 2;
    public $leave_type = "";
    public $specific_date, $start_date, $end_date; 
    public $reason = "";

    // view
    public $selected_leave = [];
    public $selected_user_id = null;
    public $selected_type_id = null;
    public $selected_leave_type_id = null;
    public $selected_start_date = null;
    public $selected_end_date = null;
    public $selected_hours_duration = null;
    public $selected_reason = null;
    public $selected_status = null;
    public $selected_is_paid = null;

    // table filter
    public $search = "", $search_status = "";

    // download dmin
    public $download_start_date = "";
    public $download_end_date = "";



    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.leave.leave-component',[
            'users' => $this->users,
            'leaves' => $this->leaves,
            'leave_types' => $this->leave_types,
        ])
        ->layout('layouts.app',  ['menu' => 'leave']);
    }

    public function getLeavesProperty()
    {
        if(Auth::user()->hasRole('administrator'))
        {
            $search = $this->search;
            $search_status = $this->search_status;

            return Leave::latest('leaves.updated_at')
            ->leftJoin('users', 'users.id', '=', 'leaves.user_id')
            ->where(function ($query) use ($search) {
                return $query->where('users.last_name', 'like', '%' . $search . '%')
                ->orWhere('users.first_name', 'like', '%' . $search . '%')
                ->orWhere('users.code', 'like', '%' . $search . '%');
            })
            ->where(function ($query) use ($search_status) {
                if($search_status != "") {
                    return $query->where('leaves.status', $search_status);
                }
            })
            ->select('leaves.*', 'users.id as user_user_id')
            ->paginate(10);
        }
        else {
            return Leave::where('user_id', Auth::user()->id)
            ->latest('created_at')->paginate(10);
        }
        
    }

    public function getLeaveTypesProperty()
    {
        return LeaveType::where('is_active', true)->get();
    }

    public function getUsersProperty()
    {
        return User::where('is_active', true)
        ->get();
    }


    public function applyLeave()
    {
        if(Auth::user()->hasRole('administrator'))
        {
            $this->validate([
                'user_id' => 'required',
                'type' => 'required',
                'leave_type' => 'required',
                'reason'=> 'required',
                'start_date' => 'required|date',
                'end_date' => 'required_if:type,3|nullable|date|after:start_date',
            ]);

        }

        else 
        {
            $this->validate([
                'type' => 'required',
                'leave_type' => 'required',
                'reason'=> 'required|max:255',
                'start_date' => 'required|date|after:today',
                'end_date' => 'required_if:type,3|nullable|date|after:start_date',
            ]);
        }
        

        $status = 1;
        if(Auth::user()->hasRole('administrator'))
        {
            $status = 2;
        }

        
        // if above day
        $hours_duration = 0;
        if($this->type == 1) {
            $hours_duration = 8;
        } elseif($this->type == 2) {
            $hours_duration = 4;
        } elseif($this->type == 3){
            $hours_duration = Helper::getHoursDurationWorkingDay($this->start_date, $this->end_date);
        }

        // user id
        if(Auth::user()->hasRole('administrator'))
        {
            $user_id = $this->user_id;
        } else {
            $user_id = Auth::user()->id;
        }

        $new_leave = new Leave;
        $new_leave->user_id = $user_id;
        $new_leave->type_id = $this->type;
        $new_leave->leave_type_id = $this->leave_type;
        $new_leave->start_date = $this->start_date;
        if($this->type == 3) {
        $new_leave->end_date = $this->end_date;
        }
        $new_leave->hours_duration = $hours_duration;
        $new_leave->status = $status;
        $new_leave->reason = $this->reason;
        $new_leave->is_paid = false;
        $new_leave->save();

        Self::clear();
        $this->emit('openNotifModal');

    }

    public function clear()
    {
        $this->user_id = null;
        $this->type = 2;
        $this->leave_type = "";
        $this->start_date = "";
        $this->end_date = "";
        $this->reason = "";
    }

    public function userDownload()
    {
        $data = Leave::where('user_id', Auth::user()->id)
        ->latest('created_at')->get();
        
        $filename = Carbon::now()->format("Y-m-d") . " " . Auth::user()->code . " " . ' Leave History.xlsx';
        return Excel::download(new UserLeaveHistoryExport($data), $filename);
    }

    public function leaveDetails($value)
    {
        $this->selected_leave = Leave::find($value);
        $this->selected_user_id = $this->selected_leave->user_id;
        $this->selected_type_id = $this->selected_leave->type_id;
        $this->selected_leave_type_id = $this->selected_leave->leave_type_id;
        $this->selected_start_date = $this->selected_leave->start_date;
        $this->selected_end_date = $this->selected_leave->end_date;
        $this->selected_hours_duration = $this->selected_leave->hours_duration;
        $this->selected_reason = $this->selected_leave->reason;
        $this->selected_status = $this->selected_leave->status;
        $this->selected_is_paid = $this->selected_leave->is_paid;

        $this->emit('openLeaveDetailsModal');
    }

    public function updateLeaveDetails()
    {
        $this->validate([
            'selected_type_id' => 'required',
            'selected_leave_type_id' => 'required',
            'selected_reason'=> 'required|max:255',
            'selected_start_date' => 'required|date',
            'selected_end_date' => 'required_if:type,3|nullable|date|after:start_date',
        ]);

        if(Auth::user()->hasRole('administrator'))
        {
            $status = $this->selected_status;

        } else {
            $status = 1;
        }

        
        // if above day
        $hours_duration = 0;
        if($this->type == 1) {
            $hours_duration = 8;
        } elseif($this->type == 2) {
            $hours_duration = 4;
        } elseif($this->type == 3){
            $hours_duration = Helper::getHoursDurationWorkingDay($this->start_date, $this->end_date);
        }

        $this->selected_leave->type_id = $this->selected_type_id;
        $this->selected_leave->leave_type_id = $this->selected_leave_type_id;
        $this->selected_leave->start_date = $this->selected_start_date;
        $this->selected_leave->end_date = $this->selected_end_date;
        $this->selected_leave->hours_duration = $hours_duration;
        $this->selected_leave->status = $status;
        $this->selected_leave->reason = $this->selected_reason;
        $this->selected_leave->is_paid = $this->selected_is_paid;
        $this->selected_leave->save();

        Self::clear();
        $this->emit('openNotifModal');
        $this->emit('closeLeaveDetailsModal');

    }

    public function downloadLeaveHistory()
    {
        $start_date = $this->download_start_date;
        $end_date = $this->download_end_date;
        
        $data = Leave::query()
        ->where(function ($query) use ($start_date, $end_date){
            if($start_date && $end_date) {
                return $query->whereBetween('created_at',[$start_date, $end_date]);
            } elseif($start_date) {
                return $query->where('created_at', '>=', $start_date);
            } elseif($end_date) {
                return $query->where('created_at', '<=', $end_date);
            }
        })
        ->latest('created_at')->get();
        $this->emit('closeDownloadModal');

        $filename = Carbon::now()->format("Y-m-d") . " " . ' Leave History.xlsx';
        return Excel::download(new LeaveHistoryExport($data), $filename);
    }
}
