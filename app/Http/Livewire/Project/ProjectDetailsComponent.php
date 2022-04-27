<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Models\Project;
use App\Models\Timekeeper;
use App\Models\User;

class ProjectDetailsComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $project;
    public $search = "";
    public $search_add = "";
    public $perPage = 10;
    public $selected_users_to_add = [];
    public $selected_users_to_remove = [];

    public $name;
    public $code;
    public $location;
    public $details;
    public $start_date;
    public $end_date;
    public $is_subcontractual;
    public $profile_photo_path;

    public $current_timekeeper = null;
    public $selected_timekeeper = null;
    

    public function mount(Request $request)
    {
        $this->project = Project::where('code', $request->id)->first();
        if($this->project)
        {
            // dd($this->users_to_add);
            $this->name = $this->project->name;
            $this->code = $this->project->code;
            $this->location = $this->project->location;
            $this->details = $this->project->details;
            $this->start_date = $this->project->start_date;
            $this->end_date = $this->project->end_date;
            $this->is_subcontractual = $this->project->is_subcontractual;
            
            Self::findTimekeeper();
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
            'users_to_add' => $this->users_to_add,
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
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->paginate($this->perPage);
    }

    public function getUsersToAddProperty()
    {
        // dd($this->project->users->pluck('id'));
        $search = $this->search_add;

        return User::whereNotIn('id', $this->project->users->pluck('id'))
        ->latest('hired_date')
        ->where(function ($query) use ($search) {
            return $query->where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%');
        })
        ->get();
    }

    public function submitUsers()
    {
        $this->project->users()->attach($this->selected_users_to_add);
        $this->emit('closeAddUsersModal');
        $this->emit('openNotifModal');
    }

    public function removeUsers()
    {
        $this->project->users()->detach($this->selected_users_to_remove);
        $this->emit('closeRemoveUsersModal');
    }

    public function deleteProject()
    {
        $this->project->delete();
        $this->emit('closeDeleteProjectModal');
        return redirect()->route('project');
    }

    public function updateProject()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255',
            'code' => 'required|unique:projects,code,'. $this->project->id,
            'is_subcontractual' => 'required',
        ]);

        $this->project->name = $this->name;
        $this->project->code = $this->code;
        $this->project->location = $this->location;
        $this->project->details = $this->details;
        $this->project->start_date = $this->start_date;
        $this->project->end_date = $this->end_date;
        $this->project->is_subcontractual = $this->is_subcontractual;
        $this->project->save();

        $this->emit('closeUpdateProjectModal');
    }

    public function updateStatus()
    {
        if($this->project->status == 1 || $this->project->status == 2)
        {
            $this->project->status += 1;
        } else {
            $this->project->status = 1;
        }
        $this->project->save();
    }

    public function updateImage()
    {
        // validate
        $this->validate([
            'profile_photo_path' => "nullable|image|mimes:jpg,png,jpeg|max:2048",
        ]);

        $this->emit('closeUpdateImageModal');

        $imageFileName = null;
        if($this->profile_photo_path != null)
        {
            $imageFileName = $this->code . $this->profile_photo_path->extension();

            $this->profile_photo_path->storeAs('public/img/projects', $imageFileName);
        }

        $this->project->profile_photo_path = $imageFileName;
        $this->project->save();
           
    }

    public function removeCurrentTimekeeper()
    {
        $this->current_timekeeper->delete();
        $this->current_timekeeper = null;
    }

    public function assignTimekeeper()
    {
        $this->validate([
            'selected_timekeeper' => 'required|numeric',
        ]);

        $user = User::find($this->selected_timekeeper);
        $user->attachRole('timekeeper');

        $this->project->timekeepers()->attach($this->selected_timekeeper, ['user_id' => $this->selected_timekeeper]);
        $this->emit('closeAssignTimekeeperModal');
        Self::findTimekeeper();
    }
    
    public function findTimekeeper()
    {
        $this->current_timekeeper = Timekeeper::where('project_id', $this->project->id)->latest('updated_at')->first();
    }
}
