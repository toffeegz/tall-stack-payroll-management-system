<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class ProjectComponent extends Component
{
    use WithFileUploads;

    public $page = 1;

    public $search = "";
    public $search_user = "";
    public $perPage = 5;

    public $profile_photo_path;
    public $name;
    public $code;
    public $location = null;
    public $start_date = null;
    public $end_date = null;
    public $details = null;
    public $status = 3;
    public $is_subcontractual = false;

    public $selected_users = [];

    public function render()
    {
        return view('livewire.project.project-component',[
            'projects' => $this->projects,
            'users' => $this->users,
        ])
        ->layout('layouts.app',  ['menu' => 'project']);
    }

    public function getProjectsProperty()
    {
        $search = $this->search;
        return Project::query()->where(function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%')
            ->orWhere('details', 'like', '%' . $search . '%')   ;
        })
        ->paginate($this->perPage);
    }

    public function getUsersProperty()
    {
        $search = $this->search_user;
        return User::query()->where(function ($query) use ($search) {
            return $query->where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%');
        })
        ->get();
    }

    public function openProject($value)
    {
        $this->selected_project = Project::find($value);
        $this->emit('openProjectDetailsModal');
    }

    public function nextPage()
    {
        if($this->page == 1)
        {
            // validate
            $this->validate([
                'name' => 'required|string|min:2|max:255',
                'code' => 'required|unique:projects,code',
                'profile_photo_path' => "nullable|image|mimes:jpg,png,jpeg|max:2048",//2mb
                // location
            ]);


            $this->page += 1;
        } 
        elseif($this->page == 2)
        {
            $this->validate([
                // 'start_date' => 'required|date|',
                // 'end_date' => 'nullable|string|min:2|max:255',
                // 'details' => 'required|unique:users,code',
                'status' => 'required|numeric',
                'is_subcontractual' => 'required',
            ]);

            $this->page += 1;
        } 
        elseif($this->page == 3) 
        {
            $this->emit('closeNewProjectModal');

            $imageFileName = null;
            if($this->profile_photo_path != null)
            {
                $imageFileName = $this->code . $this->profile_photo_path->extension();

                $this->profile_photo_path->storeAs('public/img/projects', $imageFileName);
            }
           
            
            $new_project = new Project;
            $new_project->name = $this->name;
            $new_project->code = $this->code;
            $new_project->profile_photo_path = $imageFileName;
            $new_project->location = $this->location;
            $new_project->start_date = $this->start_date;
            $new_project->end_date = $this->end_date;
            $new_project->details = $this->details;
            $new_project->status = $this->status;
            $new_project->is_subcontractual = $this->is_subcontractual;
            $new_project->save();

            $new_project->users()->attach($this->selected_users);

            $this->emit('openNotifModal');

            Self::clearNewProjectForm();
            $this->page = 1;

        }

       
    }

    public function backPage()
    {
        if($this->page == 1)
        {
            $this->emit('closeNewProjectModal');
        } else {
            $this->page -= 1;
        }
        
    }

    public function clearNewProjectForm()
    {
        $this->name = "";
        $this->code = "";
        $this->profile_photo_path = null;
        $this->location = "";
        $this->start_date = "";
        $this->end_date = "";
        $this->details = "";
        $this->status = 2;
        $this->is_subcontractual = false;
    }
}
