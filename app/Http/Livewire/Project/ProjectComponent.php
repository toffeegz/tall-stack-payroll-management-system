<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Project;
use App\Models\User;
use App\Exports\Project\ProjectExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class ProjectComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $newPage = 1;

    public $search = "";
    public $search_user = "";
    public $perPage = 5;

    public $profile_photo_path;
    public $name;
    public $code;
    public $auto_generate_code = true;
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

    public function mount()
    {
        Self::updatedAutoGenerateCode();
    }

    public function getProjectsQueryProperty()
    {
        $search = $this->search;
        return Project::query()->where(function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%')
            ->orWhere('details', 'like', '%' . $search . '%')   ;
        })
        ->latest();
    }

    public function getProjectsProperty()
    {
        return $this->projects_query
        ->paginate($this->perPage);
    }

    public function download()
    {
        $data = $this->projects_query->get();
        $filename = Carbon::now()->format("Y-m-d") . " " . ' Project Export.xlsx';
        return Excel::download(new ProjectExport($data), $filename);
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
        $project = Project::find($value);
        $code  = $project->code;
        return redirect()->route('project.details', ['id'=>$code]);
    }

    public function nextPage()
    {

        if($this->newPage == 1)
        {
            // validate
            $this->validate([
                'name' => 'required|string|min:2|max:255',
                'code' => 'required|unique:projects,code',
                'profile_photo_path' => "required|image|mimes:jpg,png,jpeg|max:2048",//2mb
                // location
            ]);
            $this->newPage += 1;
        } elseif($this->newPage == 2)
        {
            $this->newPage += 1;
        } elseif($this->newPage == 3) 
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
            $this->newPage = 1;

        }
        
        
        

       
    }

    public function backPage()
    {
        if($this->newPage == 1)
        {
            $this->emit('closeNewProjectModal');
        } else {
            $this->newPage -= 1;
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

    public function updatedAutoGenerateCode()
    {
        $latest_project = Project::orderBy('code', 'desc')->first();
        $latest_code = $latest_project->code;
        $last_digits = substr($latest_code, 6) + 1;
        $this->code = Carbon::now()->format('Y') . "-" . sprintf('%04d', $last_digits);
    }
}
