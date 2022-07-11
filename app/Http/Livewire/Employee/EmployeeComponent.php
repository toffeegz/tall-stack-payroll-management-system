<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;

class EmployeeComponent extends Component
{
    
    public $page_name;
    
    public function mount()
    {
        $this->page_name = 'lists';
    }

    public function render()
    {
        return view('livewire.employee.employee-component')
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function page($value)
    {
        $this->page_name = $value;
    }
}
