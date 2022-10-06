<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Payslip;

class PayrollPeriod extends Model
{
    use HasFactory;
    use SoftDeletes;

    const FREQUENCY_BIMONTHLY = 1;
    const FREQUENCY_WEEKLY = 2;

    protected $fillable = [
        'period_start',
        'period_end',
        'payout_date',
        'year',
        'cutoff_order',
        'frequency_id',
        'is_payroll_generated',
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }
}
