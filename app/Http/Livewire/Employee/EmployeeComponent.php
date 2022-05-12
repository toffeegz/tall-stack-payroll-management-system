<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Exports\Employee\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class EmployeeComponent extends Component
{
    use WithPagination;
    public $search = "";
    public $perPage = 5;

    public function mount()
    {
        // dd($this->users_query->get());
    }

    public function render()
    {
        return view('livewire.employee.employee-component',[
            'users' => $this->users,
        ])
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function getUsersProperty()
    {
        return $this->users_query->paginate($this->perPage);
    }

    public function getUsersQueryProperty()
    {
        $search = $this->search;

        return User::latest()
        ->where(function ($query) use ($search) {
            return $query->where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    public function download()
    {
        $data = $this->users_query->get();
        $filename = Carbon::now()->format("Y-m-d") . " " . ' Employees Export.xlsx';
        return Excel::download(new EmployeeExport($data), $filename);
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
