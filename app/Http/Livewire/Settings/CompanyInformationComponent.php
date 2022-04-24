<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Department;
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
}
