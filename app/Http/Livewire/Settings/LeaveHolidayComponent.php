<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\LeaveType;
use App\Models\Holiday;

class LeaveHolidayComponent extends Component
{
    public function render()
    {
        return view('livewire.settings.leave-holiday-component',[
            'leave_types' => $this->leaveTypes,
            'holidays' => $this->holidays,
        ]);
    }

    public function getLeaveTypesProperty()
    {
        return LeaveType::all();
    }

    public function getHolidaysProperty()
    {
        return Holiday::all();
    }
}
