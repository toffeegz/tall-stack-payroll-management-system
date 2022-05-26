<?php

namespace App\Http\Livewire\Employee\Profile;

use Livewire\Component;
use App\Models\User;

class PersonalInformationComponent extends Component
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $phone_number;
    public $email;
    public $gender;
    public $marital_status;
    public $nationality;
    public $birth_date;
    public $birth_place;
    public $fathers_name;
    public $mothers_name;
    public $number_dependent;
    public $address;
    public $profile_photo_path;

    public $user_id;
    public $user;

    public function render()
    {
        return view('livewire.employee.profile.personal-information-component');
    }

    public function mount()
    {
        $this->user = User::find($this->user_id);
        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->last_name = $this->user->last_name;
        $this->suffix_name = $this->user->suffix_name;
        $this->phone_number = $this->user->phone_number;
        $this->email = $this->user->email;
        $this->gender = $this->user->gender;
        $this->marital_status = $this->user->marital_status;
        $this->nationality = $this->user->nationality;
        $this->birth_date = $this->user->birth_date;
        $this->birth_place = $this->user->birth_place;
        $this->fathers_name = $this->user->fathers_name;
        $this->mothers_name = $this->user->mothers_name;
        $this->number_dependent = $this->user->number_dependent;
        $this->address = $this->user->address;
    }
}
