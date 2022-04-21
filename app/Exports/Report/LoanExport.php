<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LoanExport implements FromView
{
    public function __construct($data, $collection) {
        $this->data = $data;
        $this->collection = $collection;
    }
    
    public function view(): View
    {
        // dd($this->collection);   
        return view('reports.loan', ['data' => $this->data, 'collection' => $this->collection]);
    }
}
