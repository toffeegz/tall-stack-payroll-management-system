<?php

namespace App\Exports\Loan;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanInstallmentExport implements FromView, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data = $data;
    }
    
    public function view(): View
    {  
        return view('reports.loan.loan-installment-export', ['data' => $this->formatCollection($this->data)]);
    }

    public function headings(): array
    {
        return [
            'Amount'
        ];
    }

    private function formatCollection($collection)
    {
        return $collection->map(function ($loan) {
            $loan->amount = number_format($loan->amount, 2, '.', ',');
            // Convert the values to strings
            $loan->amount = strval($loan->amount) . "\u{00A0}";
            return $loan;
        });
    }
}
