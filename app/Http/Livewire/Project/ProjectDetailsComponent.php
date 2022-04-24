<?php

namespace App\Http\Livewire\Project;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Project;

class ProjectDetailsComponent extends Component
{
    public $project;

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
        return view('livewire.project.project-details-component');
    }
}
