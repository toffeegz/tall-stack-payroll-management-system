<?php

namespace App\Exports\Employee;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {  
        return view('reports.employee.employee-export', ['data' => $this->data]);
    }
}
