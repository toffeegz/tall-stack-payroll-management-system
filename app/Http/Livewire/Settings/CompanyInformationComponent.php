<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Department;
use App\Models\CompanyInformation;
use Helper;

class CompanyInformationComponent extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;

    public function mount()
    {
        $this->name = Helper::getCompanyInformation()->name;
        $this->email = Helper::getCompanyInformation()->email;
        $this->phone = Helper::getCompanyInformation()->phone;
        $this->address = Helper::getCompanyInformation()->address;
    }

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

    public function editCompanyInformation()
    {
        $this->validate([
            'name' => 'required|min:2|max:30',
            'email' => 'required|email',
        ]);

        $company = CompanyInformation::find(1);
        $company->name = $this->name;
        $company->email = $this->email;
        $company->phone = $this->phone;
        $company->address = $this->address;
        $company->save();

        $this->emit('closeEditCompanyInformationModal');
        
    }
}
