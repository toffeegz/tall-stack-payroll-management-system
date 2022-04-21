<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeListExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
