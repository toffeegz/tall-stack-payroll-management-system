<?php

namespace App\Http\Livewire\Employee;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Carbon\Carbon;

class ProfileComponent extends Component
{
    public $user;

    // personal information
    public $last_name = "";
    public $first_name = "";
    public $middle_name = "";
    public $code = "";
    public $email = "";
    public $phone_number = "";
    public $gender = "";
    public $marital_status = "";
    public $birth_date = "";
    public $nationality = "";
    public $fathers_name = "";
    public $mothers_name = "";
    public $address = "";

    // 
    public $employment_status = "";
    public $hired_date = "";
    public $is_active = false;

    public $department_id = "";
    public $designation_id = "";

    public $daily_rate = 0; 
    
    public $is_tax_exempted = false;
    public $is_paid_holidays = false;
    public $sss_number = null;
    public $hdmf_number = null;
    public $phic_number = null;

    public function mount(Request $request)
    {
        $code = $request->user;
        $this->user = User::where('code', $code)->first();
        if(!$this->user)
        {
            return abort(404);
        } else {
            $this->last_name = $this->user->last_name;
            $this->first_name = $this->user->first_name;
            $this->middle_name = $this->user->middle_name;
            $this->code = $this->user->code;
            $this->email = $this->user->email;
            $this->phone_number = $this->user->phone_number;
            $this->gender = $this->user->gender;
            $this->marital_status = $this->user->marital_status;
            $this->birth_date = $this->user->birth_date;
            $this->nationality = $this->user->nationality;
            $this->fathers_name = $this->user->fathers_name;
            $this->mothers_name = $this->user->mothers_name;
            $this->address = $this->user->address;

            $this->employment_status = $this->user->employment_status;
            $this->hired_date = $this->user->hired_date;
            $this->is_active = $this->user->is_active;

            if($this->user->latestDesignation())
            {
                $this->designation_id = $this->user->latestDesignation()->id;
                $this->department_id = $this->user->latestDesignation()->department->id;
            }

            $this->is_tax_exempted = $this->user->is_tax_exempted;
            $this->is_paid_holidays = $this->user->is_paid_holidays;

            $this->sss_number = $this->user->sss_number;
            $this->hdmf_number = $this->user->hdmf_number;
            $this->phic_number = $this->user->phic_number;


        }


    }

    public function render()
    {
        return view('livewire.employee.profile-component',[
            'departments' => $this->departments,
            'designations' => $this->designations,
        ])
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function getDepartmentsProperty()
    {
        return Department::all();
    }
    
    public function getDesignationsProperty()
    {
        return Designation::query()
        ->where('department_id', $this->department_id)
        ->get();
    }

    public function updatedDesignationId($value)
    {
        $this->daily_rate = Designation::find($value)->value('daily_rate');
    }  


    // submit

    public function submitPersonalInformation()
    {
        $this->validate([
            'last_name' => 'required|string|min:2|max:255',
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|min:2|max:255',
            // 'code' => 'required|unique:users,code',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'gender' => 'required|numeric',
            'marital_status' => 'required|numeric',
            'birth_date' => 'required|date|before:today',
            'nationality' => 'required|',
            'fathers_name' => 'nullable',
            'mothers_name' => 'nullable',
            'address' => 'nullable|max:255',
        ]);

        $this->user->last_name = $this->last_name;
        $this->user->first_name = $this->first_name;
        $this->user->middle_name = $this->middle_name;
        $this->user->code = $this->code;
        $this->user->email = $this->email;
        $this->user->phone_number = $this->phone_number;
        $this->user->gender = $this->gender;
        $this->user->marital_status = $this->marital_status;
        $this->user->birth_date = $this->birth_date;
        $this->user->nationality = $this->nationality;
        $this->user->fathers_name = $this->fathers_name;
        $this->user->mothers_name = $this->mothers_name;
        $this->user->address = $this->address;

        $this->user->save();

        $this->emit('closePersonalInformationModal');
    }

    public function submitEmploymentDetails()
    {
        $this->validate([
            'employment_status' => 'required|numeric',
            'hired_date' => 'required|date|',
            'is_active' => 'required|boolean',
        ]);

        $this->user->employment_status = $this->employment_status;
        $this->user->hired_date = $this->hired_date;
        $this->user->is_active = $this->is_active;

        $this->user->save();
        $this->emit('closeEmploymentDetailsModal');

    }
    
    public function submitCompensation()
    {
        $this->validate([
            'designation_id' => 'required|numeric',
            'sss_number' => 'nullable|max:255',
            'hdmf_number' => 'nullable|max:255',
            'phic_number' => 'nullable|max:255',
        ]);

        $this->user->sss_number = $this->sss_number;
        $this->user->hdmf_number = $this->hdmf_number;
        $this->user->phic_number = $this->phic_number;
        $this->user->save();
        
        $new_designation = DB::table('designation_user')->insert([
            'user_id' => $this->user->id,
            'designation_id' => $this->designation_id,
            "created_at" => Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
        ]);
        
        $this->emit('closeCompensationModal');
    }

}
