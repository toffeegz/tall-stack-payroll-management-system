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
        $this->project = Project::find($request->id);
    }

    public function render()
    {
        return view('livewire.project.project-details-component');
    }
}
