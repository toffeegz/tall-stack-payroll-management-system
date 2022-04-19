<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'period_start',
        'period_end',
        'employee_ids',
        'additional_earnings',
        'others',
    ];
}
