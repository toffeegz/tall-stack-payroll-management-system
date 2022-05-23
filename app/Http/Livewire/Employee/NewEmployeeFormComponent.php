<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DraftLogs;

class NewEmployeeFormComponent extends Component
{
    use WithFileUploads;
    public $page = 1;

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
    public $number_dependent;
    public $address = "";

    // 
    public $employment_status = "";
    public $hired_date = "";
    public $is_active = false;

    public $department_id = 1;
    public $designation_id = null;

    public $daily_rate = 0; 
    public $frequency_id;
    
    public $is_tax_exempted = false;
    public $is_paid_holidays = false;

    public $sss_number;
    public $phic_number;
    public $hdmf_number;

    public $profile_photo_path;
    public $auto_generate_code = true;

    public $selected_designation;
    public $selected_draft = "";

    public function mount()
    {
        Self::updatedAutoGenerateCode();
    }

    public function render()
    {
        return view('livewire.employee.new-employee-form-component',[
            'departments' => $this->departments,
            'designations' => $this->designations,
            'drafts' => $this->drafts,
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

    public function updatedDepartmentId()
    {
        $this->designation_id = null;
    }

    public function updatedAutoGenerateCode()
    {
        $latest_user = User::orderBy('code', 'desc')->first();
        $latest_code = $latest_user->code;
        $last_digits = substr($latest_code, 6) + 1;
        $this->code = Carbon::now()->format('Y') . "-" . sprintf('%04d', $last_digits);
    }

    public function getDraftsProperty()
    {
        return DraftLogs::where('code', 1)->get();
    }

    public function updatedSelectedDraft()
    {
        if($this->selected_draft != "")
        {
            $existing_draft = DraftLogs::find($this->selected_draft);
            $data = json_decode($existing_draft->value, true);
            $this->last_name = $data['last_name'];
            $this->first_name = $data['first_name'];
            $this->middle_name = $data['middle_name'];
            $this->suffix_name = $data['suffix_name'];
            $this->code = $data['code'];
            $this->email = $data['email'];
            $this->phone_number = $data['phone_number'];
            $this->gender = $data['gender'];
            $this->marital_status = $data['marital_status'];
            $this->birth_date = $data['birth_date'];
            $this->birth_place = $data['birth_place'];
            $this->nationality = $data['nationality'];
            $this->fathers_name = $data['fathers_name'];
            $this->mothers_name = $data['mothers_name'];
            $this->number_dependent = $data['number_dependent'];
            $this->address = $data['address'];
            $this->employment_status = $data['employment_status'];
            $this->hired_date = $data['hired_date'];
            $this->is_active = $data['is_active'];
            $this->department_id = $data['department_id'];
            $this->designation_id = $data['designation_id'];
            $this->daily_rate = $data['daily_rate'];
            $this->frequency_id = $data['frequency_id'];
            $this->is_tax_exempted = $data['is_tax_exempted'];
            $this->is_paid_holidays = $data['is_paid_holidays'];
            $this->sss_number = $data['sss_number'];
            $this->phic_number = $data['phic_number'];
            $this->hdmf_number = $data['hdmf_number'];
            $this->profile_photo_path = $data['profile_photo_path'];
            $this->auto_generate_code = $data['auto_generate_code'];
            $this->selected_designation = $data['selected_designation'];
        }
    }

    // save informations
    public function saveInformations()
    {
        $this->validate([
            'first_name' =>  'required|',
            'last_name' => 'required|',
        ]);

        $imageFileName = null;
        if($this->profile_photo_path != null)
        {
            $imageFileName = $this->code . $this->profile_photo_path->extension();

            $this->profile_photo_path->storeAs('public/img/users', $imageFileName);
        }

        $data = [
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'suffix_name' => $this->suffix_name,
            'code' => $this->code,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'birth_date' => $this->birth_date,
            'birth_place' => $this->birth_place,
            'nationality' => $this->nationality,
            'fathers_name' => $this->fathers_name,
            'mothers_name' => $this->mothers_name,
            'number_dependent' => $this->number_dependent,
            'address' => $this->address,
            'employment_status' => $this->employment_status,
            'hired_date' => $this->hired_date,
            'is_active' => $this->is_active,
            'department_id' => $this->department_id,
            'designation_id' => $this->designation_id,
            'daily_rate' => $this->daily_rate,
            'frequency_id' => $this->frequency_id,
            'is_tax_exempted' => $this->is_tax_exempted,
            'is_paid_holidays' => $this->is_paid_holidays,
            'sss_number' => $this->sss_number,
            'phic_number' => $this->phic_number,
            'hdmf_number' => $this->hdmf_number,
            'profile_photo_path' => $imageFileName,
            'auto_generate_code' => $this->auto_generate_code,
            'selected_designation' => $this->selected_designation,
        ];

        $full_name = $this->first_name . " " . $this->last_name;

        

        if($this->selected_draft != "") {
            $draft = DraftLogs::find($this->selected_draft);
        } else {
            $draft_exist = DraftLogs::where('code', 1)
            ->where('name', $full_name)->first();
            if($draft_exist) {
                $draft_exist->delete();
            }
            $draft = new DraftLogs;
            $draft->code = 1;

            $this->selected_draft = "";
        }

        $draft->name = $full_name;
        $draft->value = json_encode($data);
        $draft->save();

    }

    public function submit()
    {
        dd($this->selected_designation);
    }

    public function selectDesignation($value)
    {
        $this->selected_designation = $value;
    }



    // proceed submit insert
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
        $new_user->sss_number = $this->sss_number;
        $new_user->hdmf_number = $this->hdmf_number;
        $new_user->phic_number = $this->phic_number;
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
