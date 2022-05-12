<?php

namespace App\Exports\Attendance;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {  
        return view('reports.attendance.attendance-export', ['data' => $this->data]);
    }
}
