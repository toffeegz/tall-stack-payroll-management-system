<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\PayrollPeriod;

class Payslip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'payroll_period_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payroll_period()
    {
        return $this->belongsTo(PayrollPeriod::class);
    }
}
