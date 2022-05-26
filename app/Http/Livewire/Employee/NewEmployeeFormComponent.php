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

    public $frequency_id = 2;
    
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
        $this->selected_designation = null;
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
            $this->frequency_id = $data['frequency_id'];
            $this->is_tax_exempted = $data['is_tax_exempted'];
            $this->is_paid_holidays = $data['is_paid_holidays'];
            $this->sss_number = $data['sss_number'];
            $this->phic_number = $data['phic_number'];
            $this->hdmf_number = $data['hdmf_number'];
            $this->auto_generate_code = $data['auto_generate_code'];
            $this->selected_designation = $data['selected_designation'];

            $designation = Designation::find($this->selected_designation);
            $this->department_id = $designation->department_id;
        } 
        else 
        { 
            $this->last_name = "";
            $this->first_name = "";
            $this->middle_name = "";
            $this->suffix_name = "";
            $this->code = "";
            $this->email = "";
            $this->phone_number = "";
            $this->gender = "";
            $this->marital_status = "";
            $this->birth_date = "";
            $this->birth_place = "";
            $this->nationality = "";
            $this->fathers_name = "";
            $this->mothers_name = "";
            $this->number_dependent = "";
            $this->address = "";
            $this->employment_status = "";
            $this->hired_date = "";
            $this->is_active = "";
            $this->frequency_id = "";
            $this->is_tax_exempted = "";
            $this->is_paid_holidays = "";
            $this->sss_number = "";
            $this->phic_number = "";
            $this->hdmf_number = "";
            $this->profile_photo_path = "";
            $this->auto_generate_code = true;
            $this->selected_designation = null;

            Self::updatedAutoGenerateCode();

        }
    }

    // save informations
    public function saveInformations()
    {
        Self::scrollTop();
        $this->validate([
            'first_name' =>  'required|',
            'last_name' => 'required|',
        ]);

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
            'frequency_id' => $this->frequency_id,
            'is_tax_exempted' => $this->is_tax_exempted,
            'is_paid_holidays' => $this->is_paid_holidays,
            'sss_number' => $this->sss_number,
            'phic_number' => $this->phic_number,
            'hdmf_number' => $this->hdmf_number,
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
        Self::scrollTop();

        if($this->selected_draft != "" || $this->selected_draft != null)
        {
            $draft = DraftLogs::find($this->selected_draft)->delete();
        }

        $this->validate([
            'last_name' => 'required|string|min:2|max:255',
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|min:2|max:255',
            'suffix_name' => 'nullable|string|min:2|max:10',
            'code' => 'required|unique:users,code',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'gender' => 'required|numeric',
            'marital_status' => 'required|numeric',
            'birth_date' => 'required|date|before:today',
            'birth_place' => 'nullable|max:255',
            'nationality' => 'required|',
            'fathers_name' => 'nullable',
            'mothers_name' => 'nullable',
            'number_dependent' => 'nullable',
            'address' => 'nullable|max:255',
            'employment_status' => 'required|numeric',
            'hired_date' => 'required|date|',
            'is_active' => 'required|boolean',
            'is_tax_exempted' => 'required|boolean',
            'is_paid_holidays' => 'required|boolean',
            'frequency_id' => 'required|numeric',
            'profile_photo_path' => "nullable|image|mimes:jpg,png,jpeg|max:2048",//2mb
            'selected_designation' => 'required|numeric',
        ]);

        $imageFileName = null;
        if($this->profile_photo_path != null)
        {
            $imageFileName = $this->code . $this->profile_photo_path->extension();

            $this->profile_photo_path->storeAs('public/img/users', $imageFileName);
        }

        $system_access_db = DraftLogs::where('code', 2)->first();
        if($system_access_db)
        {
            $system_access = json_decode($system_access_db->value, true);
        } else {
            $system_access = false;
        }

        $new_user = new User;
        $new_user->password = Hash::make(Str::random(8));
        $new_user->last_name = $this->last_name;
        $new_user->first_name = $this->first_name;
        $new_user->middle_name = $this->middle_name;
        $new_user->suffix_name = $this->suffix_name;
        $new_user->code = $this->code;
        $new_user->profile_photo_path = $imageFileName;
        $new_user->email = $this->email;
        $new_user->phone_number = $this->phone_number;
        $new_user->gender = $this->gender;
        $new_user->marital_status = $this->marital_status;
        $new_user->birth_date = $this->birth_date;
        $new_user->birth_place = $this->birth_place;
        $new_user->nationality = $this->nationality;
        $new_user->fathers_name = $this->fathers_name;
        $new_user->mothers_name = $this->mothers_name;
        $new_user->number_dependent = $this->number_dependent;
        $new_user->address = $this->address;
        $new_user->employment_status = $this->employment_status;
        $new_user->hired_date = $this->hired_date;
        $new_user->frequency_id = $this->frequency_id;
        $new_user->sss_number = $this->sss_number;
        $new_user->hdmf_number = $this->hdmf_number;
        $new_user->phic_number = $this->phic_number;
        $new_user->is_tax_exempted = $this->is_tax_exempted;
        $new_user->is_paid_holidays = $this->is_paid_holidays;
        $new_user->is_active = true;
        $new_user->is_archive = false;
        $new_user->system_access = $system_access;
        $new_user->save();

        $new_designation = DB::table('designation_user')->insert([
            'user_id' => $new_user->id,
            'designation_id' => $this->selected_designation,
            "created_at" => Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
        ]);

        $this->emit('openNotifModal');

        return redirect()->route('employee');
    }

    public function selectDesignation($value)
    {
        $this->selected_designation = $value;
    }

    public function scrollTop()
    {
        $this->emit('scrollTop');
    }


}
