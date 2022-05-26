<?php

namespace App\Http\Livewire\Employee\Profile;

use Livewire\Component;
use App\Models\User;

class DetailsComponent extends Component
{
    public $user_id;
    
    public function render()
    {
        return view('livewire.employee.profile.details-component',[
            'upcoming_projects' => $this->upcoming_projects,
            'ongoing_projects' => $this->ongoing_projects,
            'completed_projects' => $this->completed_projects,
        ]);
    }

    public function mount()
    {
        // dd($this->upcoming_projects);
    }

    public function getUserProperty()
    {
        return User::find($this->user_id);
    }

    public function getUpcomingProjectsProperty()
    {
        return $this->user->projects->where('status', 3);
    }

    public function getOngoingProjectsProperty()
    {
        return $this->user->projects->where('status', 1);
    }

    public function getCompletedProjectsProperty()
    {
        return $this->user->projects->where('status', 2);
    }
}
