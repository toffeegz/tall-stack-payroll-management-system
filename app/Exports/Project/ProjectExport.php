<?php

namespace App\Exports\Project;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {  
        return view('reports.project.project-export', ['data' => $this->data]);
    }
}
