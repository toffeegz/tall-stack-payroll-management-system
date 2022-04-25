<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use App\Models\User;

class EmployeeComponent extends Component
{
    public $search = "";
    public $perPage = 5;

    public function render()
    {
        return view('livewire.employee.employee-component',[
            'users' => $this->users,
        ])
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function getUsersProperty()
    {
        $search = $this->search;

        return User::latest('hired_date')
        ->where(function ($query) use ($search) {
            return $query->where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->paginate($this->perPage);
    }

    // 
    public function goToProfile($id)
    {
        $user = User::find($id);
        return redirect()->route('employee.profile', ['user'=>$user->code]);
    }

    public function hireNewEmployee()
    {
        return redirect()->route('employee.hire');
    }
}
