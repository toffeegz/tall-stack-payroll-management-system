<?php

namespace App\Http\Livewire\Employee;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\User\EmploymentRequest;
use App\Http\Requests\User\PersonalInformationRequest;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DesignationUser;
use App\Models\Attendance;
use Carbon\Carbon;

class ProfileComponent extends Component
{
    public $user;
    protected $rules = null;

    // personal information
    public $last_name = "";
    public $first_name = "";
    public $middle_name = "";
    public $suffix_name = "";
    public $code = "";
    public $email = "";
    public $phone_number = "";
    public $gender = "";
    public $marital_status = "";
    public $birth_date = "";
    public $birth_place = "";
    public $nationality = "";
    public $fathers_name = "";
    public $mothers_name = "";
    public $number_dependent = "";
    public $address = "";

    // 
    public $employment_status = "";
    public $hired_date = "";
    public $is_active = false;
    public $system_access = false;
    public $is_archive = false;

    public $department_id = "";
    public $designation_id = "";

    public $daily_rate = 0; 
    
    public $is_tax_exempted = false;
    public $is_paid_holidays = false;
    public $sss_number = null;
    public $hdmf_number = null;
    public $phic_number = null;

    public $page_name;
    public $selected_input_employment;

    public function mount(Request $request)
    {
        $this->page_name = 'details';

        $code = $request->user;
        $this->user = User::where('code', $code)->withTrashed()->first();
        // $this->user = User::where('code', $code)->withTrashed()->first();
        if(!$this->user)
        {
            return abort(404);
        } else {
            $this->loadUser();
        }

    }

    public function page($value)
    {
        $this->page_name = $value;
    }
    
    public function render()
    {
        return view('livewire.employee.profile-component',[
            'departments' => $this->departments,
            'designations' => $this->designations,
            'total_hours_worked' => $this->total_hours_worked,
        ])
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function getTotalHoursWorkedProperty()
    {
        $data = Attendance::where('user_id', $this->user->id)->whereIn('status', [1,2,3])->get();
        return $data->sum('regular') + $data->sum('overtime');
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

    public function updatedDepartmentId($value)
    {
        $this->designations = Designation::where('department_id', $value)->get();
    }

    public function updatedisArchive($val)
    {
        if($val == true) {
            $this->user->delete();
            return redirect()->to('/employee');
        } else {
            $this->user->deleted_at = null;
            $this->user->save();
        }
    }

    // update
    public function updatePersonalInformation()
    {
        $this->rules = (new PersonalInformationRequest)->rules($this->user->id);
        $this->validate();

        $this->user->first_name = $this->first_name;
        $this->user->middle_name = $this->middle_name;
        $this->user->last_name = $this->last_name;
        $this->user->suffix_name = $this->suffix_name;
        $this->user->phone_number = $this->phone_number;
        $this->user->email = $this->email;
        $this->user->gender = $this->gender;
        $this->user->marital_status = $this->marital_status;
        $this->user->nationality = $this->nationality;
        $this->user->birth_date = $this->birth_date;
        $this->user->birth_place = $this->birth_place;
        $this->user->fathers_name = $this->fathers_name;
        $this->user->mothers_name = $this->mothers_name;
        $this->user->number_dependent = $this->number_dependent;
        $this->user->address = $this->address;
        $this->user->save();

        $this->loadUser();

        $this->emit('openNotifModal');
    }

    public function updateEmploymentDetails()
    {
        $this->rules = (new EmploymentRequest)->rules();
        $this->validate();
        $this->user->employment_status = $this->employment_status;
        $this->user->hired_date = $this->hired_date;
        $this->user->sss_number = $this->sss_number;
        $this->user->phic_number = $this->phic_number;
        $this->user->hdmf_number = $this->hdmf_number;
        $this->user->is_tax_exempted = $this->is_tax_exempted;
        $this->user->is_paid_holidays = $this->is_paid_holidays;

        $this->user->save();

        $this->user->designations()->attach([$this->designation_id]);
        // $designation = DesignationUser::create([
        //     'user_id' => $this->user->id,
        //     'designation_id' => $this->designation_id,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        $this->loadUser();
        $this->emit('openNotifModal');
    }

    // load
    public function loadUser()
    {
        $this->last_name = $this->user->last_name;
        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->suffix_name = $this->user->suffix_name;
        $this->code = $this->user->code;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->gender = $this->user->gender;
        $this->marital_status = $this->user->marital_status;
        $this->birth_date = $this->user->birth_date;
        $this->birth_place = $this->user->birth_place;
        $this->nationality = $this->user->nationality;
        $this->fathers_name = $this->user->fathers_name;
        $this->mothers_name = $this->user->mothers_name;
        $this->number_dependent = $this->user->number_dependent;
        $this->address = $this->user->address;

        $this->employment_status = $this->user->employment_status;
        $this->hired_date = $this->user->hired_date;
        $this->is_active = $this->user->is_active;

        if($this->user->deleted_at) 
        {
            $this->is_archive = true;
        }

        if($this->user->latestDesignation())
        {
            $this->designation_id = $this->user->latestDesignation()->id;
            $this->department_id = $this->user->latestDesignation()->department->id;
            $this->daily_rate = $this->user->latestDesignation()->daily_rate;
        }

        $this->is_tax_exempted = $this->user->is_tax_exempted;
        $this->is_paid_holidays = $this->user->is_paid_holidays;

        $this->sss_number = $this->user->sss_number;
        $this->hdmf_number = $this->user->hdmf_number;
        $this->phic_number = $this->user->phic_number;

    }
}
