<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;
use App\Models\User;

class LoanInstallment extends Model
{
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
