<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;

class LoanInstallment extends Model
{
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
