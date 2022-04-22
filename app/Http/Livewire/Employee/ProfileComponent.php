<?php

namespace App\Http\Livewire\Employee;
use Illuminate\Http\Request;
use Livewire\Component;

class ProfileComponent extends Component
{
    public function mount(Request $request)
    {
        $this->user = User::where('code', $request->code)->first();
    }
    public function render()
    {
        return view('livewire.employee.profile-component');
    }
}
