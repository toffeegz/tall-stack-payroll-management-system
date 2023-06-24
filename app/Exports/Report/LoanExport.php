<?php

namespace App\Exports\Report;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanExport implements FromView, WithHeadings
{
    public function __construct($data, $collection)
    {
        $this->data = $data;
        $this->collection = $collection;
    }
    
    public function view(): View
    {
        $formattedCollection = $this->formatCollection($this->collection);
        
        return view('reports.loan', [
            'data' => $this->data,
            'collection' => $formattedCollection
        ]);
    }

    public function headings(): array
    {
        return [
            'Balance',
            'Loan amount',
            'Install Amount',
        ];
    }
    
    private function formatCollection($collection)
    {
        return $collection->map(function ($loan) {
            $loan->balance = number_format($loan->balance, 2, '.', ',');
            $loan->amount = number_format($loan->amount, 2, '.', ',');
            $loan->installment_amount = number_format($loan->installment_amount, 2, '.', ',');

            // Convert the values to strings
            $loan->balance = strval($loan->balance) . "\u{00A0}";
            $loan->amount = strval($loan->amount) . "\u{00A0}";
            $loan->installment_amount = strval($loan->installment_amount) . "\u{00A0}";

            return $loan;
        });
    }


}
