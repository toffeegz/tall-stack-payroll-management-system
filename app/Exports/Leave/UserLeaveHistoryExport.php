<?php

namespace App\Exports\Leave;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserLeaveHistoryExport implements FromView
{
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function view(): View
    {
        // dd($this->collection);   
        return view('reports.leave.user-leave-history', ['data' => $this->data]);
    }
}
