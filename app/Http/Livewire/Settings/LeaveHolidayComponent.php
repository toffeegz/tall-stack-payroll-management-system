<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\LeaveType;
use App\Models\Holiday;

class LeaveHolidayComponent extends Component
{
    public $leave_type_name;
    public $leave_type_days;

    public $selected_leave_type;
    public $edit_leave_type_name;
    public $edit_leave_type_days;

    public $holiday_name = null;
    public $holiday_date = null;
    public $holiday_type = "1";

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

    public function addLeaveType()
    {
        $this->validate([
            'leave_type_name' => 'required|unique:leave_types,name',
            'leave_type_days' => 'required|numeric',
        ]);

        $new_leave_type = new LeaveType;
        $new_leave_type->name = $this->leave_type_name;
        $new_leave_type->days = $this->leave_type_days;
        $new_leave_type->save();

        $this->emit('closeAddLeaveTypeModal');
        $this->leave_type_name = null;
        $this->leave_type_days = null;
    }

    public function editLeaveTypeModal($value)
    {
        $this->selected_leave_type = LeaveType::find($value);
        $this->edit_leave_type_name = $this->selected_leave_type->name;
        $this->edit_leave_type_days = $this->selected_leave_type->days;
        $this->emit('openEditLeaveTypeModal');
    }

    public function editLeaveType()
    {
        $this->validate([
            'edit_leave_type_name' => 'required|unique:leave_types,name',
            'edit_leave_type_days' => 'required|numeric',
        ]);

        $this->selected_leave_type->name = $this->edit_leave_type_name;
        $this->selected_leave_type->days = $this->edit_leave_type_days;
        $this->selected_leave_type->save();

        $this->emit('closeEditLeaveTypeModal');
        $this->selected_leave_type = null;
        $this->edit_leave_type_name = null;
        $this->edit_leave_type_days = null;
    }

    public function deleteLeaveType()
    {
        $this->selected_leave_type->delete();

        $this->emit('closeEditLeaveTypeModal');
        $this->selected_leave_type = null;
        $this->edit_leave_type_name = null;
        $this->edit_leave_type_days = null;
    }

    public function addHoliday()
    {
        $this->validate([
            'holiday_name' => 'required|unique:holidays,name',
            'holiday_date' => 'required|date',
            'holiday_type' => 'required',
        ]);

        $new_holiday = new Holiday;
        $new_holiday->name = $this->holiday_name;
        $new_holiday->date = $this->holiday_date;
        $new_holiday->is_legal = $this->holiday_type;
        $new_holiday->save();

        $this->emit('closeAddHolidayModal');
        $this->holiday_name = null;
        $this->holiday_date = null;
        $this->holiday_type = 1;
    }
}
