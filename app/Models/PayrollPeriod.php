<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollPeriod extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'period_start',
        'period_end',
        'payout_date',
        'year',
        'cutoff_order',
        'frequency_id',
        'is_payroll_generated',
    ];
}
