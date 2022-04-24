<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use App\Models\Project;
use App\Models\User;

class ProjectDetailsComponent extends Component
{
    use WithPagination;
    public $project;
    public $search = "";
    public $perPage = 10;

    public function mount(Request $request)
    {
        $this->project = Project::where('code', $request->id)->first();
        if($this->project)
        {

        } 
        else 
        {
            // $message =  " No project found with ID: " . $request->id;
            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.project.project-details-component', [
            'users' => $this->users,
        ])->layout('layouts.app',  ['menu' => 'project']);

    }

    public function getUsersProperty()
    {
        $search = $this->search;

        return User::whereHas('projects', function ($query) {
            return $query->where('project_id', $this->project->id);
        })
        ->latest('hired_date')
        ->where(function ($query) use ($search) {
            return $query->where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->paginate($this->perPage);
    }

}
