<?php

namespace App\Http\Livewire\Profile\MyLeave;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Leave\UserLeaveHistoryExport;

use App\Models\Leave;
use App\Models\LeaveType;
use Helper;
use Carbon\Carbon;

class MyLeaveComponent extends Component
{

    public $type = 2;
    public $leave_type = "";
    public $specific_date, $start_date, $end_date; 
    public $reason = "";

    public function render()
    {
        return view('livewire.profile.my-leave.my-leave-component',[
            'leaves' => $this->leaves,
            'leave_types' => $this->leave_types,
        ])
        ->layout('layouts.app',  ['menu' => 'my-leave']);
    }

    public function getLeavesProperty()
    {
        return Leave::where('user_id', Auth::user()->id)
        ->latest('created_at')->paginate(10);
    }

    public static function getLeaveTypesProperty()
    {
        return LeaveType::all();
    }

    public function applyLeave()
    {
        $this->validate([
            'type' => 'required',
            'leave_type' => 'required',
            'reason'=> 'required|max:255',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required_if:type,3|nullable|date|after:start_date',
        ]);

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
        

        $new_leave = new Leave;
        $new_leave->user_id = Auth::user()->id;
        $new_leave->type_id = $this->type;
        $new_leave->leave_type_id = $this->leave_type;
        $new_leave->start_date = $this->start_date;
        $new_leave->end_date = $this->end_date;
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
        $this->type = 2;
        $this->leave_type = "";
        $this->start_date = "";
        $this->end_date = "";
        $this->reason = "";
    }

    public function download()
    {
        $data = Leave::where('user_id', Auth::user()->id)
        ->latest('created_at')->get();
        
        $filename = Carbon::now()->format("Y-m-d") . " " . Auth::user()->code . " " . ' Leave History.xlsx';
        return Excel::download(new UserLeaveHistoryExport($data), $filename);
    }


}
