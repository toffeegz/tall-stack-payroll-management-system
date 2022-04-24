<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Department;
use App\Models\Designation;
use App\Models\CompanyInformation;
use Helper;
use Livewire\WithFileUploads;

class CompanyInformationComponent extends Component
{
    use WithFileUploads;
    public $logo_path;
    public $name;
    public $email;
    public $phone;
    public $address;

    public $designation, $designation_name, $daily_rate;

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
            'logo_path' => "nullable|image|mimes:jpg,png,jpeg|max:2048",//2mb
        ]);

        $imageFileName = null;
        if($this->logo_path != null)
        {
            $imageFileName = $this->name . $this->logo_path->extension();

            $this->logo_path->storeAs('public/img/company', $imageFileName);
        }

        $company = CompanyInformation::find(1);
        $company->name = $this->name;
        $company->email = $this->email;
        $company->phone = $this->phone;
        $company->address = $this->address;
        $company->logo_path = $imageFileName;
        $company->save();

        $this->emit('closeEditCompanyInformationModal');
        
    }

    public function editDesignationModal($value)
    {
        $this->designation = Designation::find($value);
        $this->designation_name = $this->designation->designation_name;
        $this->daily_rate = $this->designation->daily_rate;

        $this->emit('openEditDesignationModal');    
    }

    public function editDesignation()
    {
        $this->validate([
            'designation_name' => 'required|string|min:2|max:255',
            'daily_rate' => 'required|numeric',
        ]);

        $this->designation->designation_name = $this->designation_name;
        $this->designation->daily_rate = $this->daily_rate;
        $this->designation->save();

        $this->emit('closeEditDesignationModal');    
        $this->designation = null;

    }
}
