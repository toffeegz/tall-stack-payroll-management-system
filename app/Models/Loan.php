<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Project;
use App\Models\LoanInstallment;

class Loan extends Model
{
    use HasFactory;
    use SoftDeletes;

    CONST PENDING = 1;
    CONST APPROVED = 2;
    CONST DISAPPROVED = 3;

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function loanInstallments()
    {
        return $this->hasMany(LoanInstallment::class);
    }
    
}
