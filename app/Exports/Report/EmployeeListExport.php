<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeListExport implements FromView
{
    public function __construct($data, $collection) {
        $this->data = $data;
        $this->collection = $collection;
    }
    
    public function view(): View
    {
        // dd($this->collection);   
        return view('reports.employee-list', ['data' => $this->data, 'collection' => $this->collection]);
    }
}
