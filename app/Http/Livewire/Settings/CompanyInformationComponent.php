<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Department;

class CompanyInformationComponent extends Component
{
    public function render()
    {
        return view('livewire.settings.company-information-component',[
            'departments' => $this->departments,
        ]);
    }

    public function getDepartmentsProperty()
    {
        return Department::all();
    }
}
