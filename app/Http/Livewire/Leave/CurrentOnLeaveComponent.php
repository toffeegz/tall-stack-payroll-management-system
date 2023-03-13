<?php

namespace App\Http\Livewire\Leave;

use Livewire\Component;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;

class CurrentOnLeaveComponent extends Component
{
    public function mount()
    {
        // dd($this->on_leaves);
    }

    public function render()
    {
        return view('livewire.leave.current-on-leave-component', [
            'leaves' => $this->on_leaves,
        ]);
    }

    public function getOnLeavesProperty()
    {
        $leave_1 = Leave::where('status', 2)
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->get();
        $leave_2 = Leave::where('status', 2)
            ->where('start_date', Carbon::now()->format('Y-m-d'))
            ->get();

        return  $leave_1->merge($leave_2);
    }

}
