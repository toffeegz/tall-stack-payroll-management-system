<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class TaxContributionExport implements FromView
{
    public function __construct($data, $collection) {
        $this->data = $data;
        $this->collection = $collection;
    }
    
    public function view(): View
    {
        // dd($this->collection);   
        return view('reports.tax-contribution', ['data' => $this->data, 'collection' => $this->collection]);
    }
}
