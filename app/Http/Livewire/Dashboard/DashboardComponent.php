<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\User;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Loan;
use App\Models\Attendance;
use Carbon\Carbon;


class DashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard-component',[
            'users_count' => $this->users_count,
            'loan_balance' => $this->loans->sum('balance'),
            'total_loan_with_balance' => $this->loans->sum('total_amount_to_pay'),
            'projects_count' => $this->projects_count,
            'on_leave_users_count' => $this->on_leave_users_count,
            'attendance_requests_count' => $this->attendance_requests_count,
            'loan_requests_count' => $this->loan_requests_count,
        ])
        ->layout('layouts.app',  ['menu' => 'dashboard']);
    }

    public function getUsersCountProperty()
    {
        return User::all()->count();
    }

    public function getLoansProperty()
    {
        return Loan::where('status', 2)->where('balance', '!=', 0)->get();
    }

    public function getProjectsCountProperty()
    {
        return Project::all()->count();
    }

    public function getOnLeaveUsersCountProperty()
    {
        $leave_1 = Leave::where('status', 2)
            ->where('start_date', '<=', Carbon::now()->format('Y-m-d'))
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->get();
        $leave_2 = Leave::where('status', 2)
            ->where('start_date', Carbon::now()->format('Y-m-d'))
            ->get();

        $leave =  $leave_1->merge($leave_2);

        return $leave->count();
    }

    public function getAttendanceRequestsCountProperty()
    {
        return Attendance::where('status', 4)->count();
    }

    public function getLoanRequestsCountProperty()
    {
        return Loan::where('status', 1)->count();
    }

}
