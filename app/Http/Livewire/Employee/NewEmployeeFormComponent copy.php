<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewEmployeeFormComponent extends Component
{
    use WithFileUploads;
    public $page = 1;

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
    public $frequency_id;
    
    public $is_tax_exempted = false;
    public $is_paid_holidays = false;

    public $profile_photo_path;

    public function mount()
    {
        // dd('ye');
    }

    public function render()
    {
        return view('livewire.employee.new-employee-form-component',[
            'departments' => $this->departments,
            'designations' => $this->designations,
        ])
        ->layout('layouts.app',  ['menu' => 'employee']);
    }

    public function nextPage()
    {
        if($this->page == 1)
        {
            // validate
            $this->validate([
                'last_name' => 'required|string|min:2|max:255',
                'first_name' => 'required|string|min:2|max:255',
                'middle_name' => 'nullable|string|min:2|max:255',
                'code' => 'required|unique:users,code',
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
        } 
        elseif($this->page == 2)
        {
            $this->validate([
                'employment_status' => 'required|numeric',
                'hired_date' => 'required|date|',
                'is_active' => 'required|boolean',
                'designation_id' => 'required|numeric',
                'frequency_id' => 'required|numeric',
                'profile_photo_path' => "nullable|image|mimes:jpg,png,jpeg|max:2048",//2mb
            ]);

            Self::insertUser();
            $this->emit('openNotifModal');

            return redirect()->route('employee');
        }

        
        $this->page += 1;
    }

    public function backPage()
    {
        $this->page -= 1;
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
 
    public function updatingDesignationId($value)
    {
        $des = Designation::find($value);
        $this->daily_rate = $des->daily_rate;
    }  

    public function insertUser()
    {
        $imageFileName = null;
        if($this->profile_photo_path != null)
        {
            $imageFileName = $this->code . $this->profile_photo_path->extension();

            $this->profile_photo_path->storeAs('public/img/users', $imageFileName);
        }
        $new_user = new User;
        $new_user->password = Hash::make(Str::random(8));
        $new_user->last_name = $this->last_name;
        $new_user->first_name = $this->first_name;
        $new_user->middle_name = $this->middle_name;
        $new_user->code = $this->code;
        $new_user->profile_photo_path = $imageFileName;
        $new_user->email = $this->email;
        $new_user->phone_number = $this->phone_number;
        $new_user->gender = $this->gender;
        $new_user->marital_status = $this->marital_status;
        $new_user->birth_date = $this->birth_date;
        $new_user->nationality = $this->nationality;
        $new_user->fathers_name = $this->fathers_name;
        $new_user->mothers_name = $this->mothers_name;
        $new_user->address = $this->address;
        $new_user->employment_status = $this->employment_status;
        $new_user->hired_date = $this->hired_date;
        $new_user->frequency_id = $this->frequency_id;
        $new_user->is_active = true;
        $new_user->save();

        $new_designation = DB::table('designation_user')->insert([
            'user_id' => $new_user->id,
            'designation_id' => $this->designation_id,
            "created_at" => Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
        ]);


        
    }
}
