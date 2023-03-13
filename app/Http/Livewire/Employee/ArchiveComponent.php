<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class ArchiveComponent extends Component
{
    use WithPagination;
    public $search = "";
    public $perPage = 5;

    public function render()
    {
        return view('livewire.employee.archive-component',[
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
        })->onlyTrashed();
    }

    public function goToProfile($id)
    {
        $user = User::where('id', $id)->onlyTrashed()->first();
        return redirect()->route('employee_archive.profile', ['user'=>$user->code]);
    }
}
