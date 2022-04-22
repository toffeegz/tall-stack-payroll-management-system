<?php

namespace App\Http\Livewire\Employee;
use Illuminate\Http\Request;
use Livewire\Component;

use App\Models\User;

class ProfileComponent extends Component
{
    public $user;

    public function mount(Request $request)
    {
        $code = $request->user;
        $this->user = User::where('code', $code)->first();
        if(!$this->user)
        {
            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.employee.profile-component')
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

}
