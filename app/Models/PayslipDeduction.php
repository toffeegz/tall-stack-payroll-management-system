<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayslipDeduction extends Model
{
    use HasFactory;
    protected $fillable = [
        'payslip_id',
        'tax_sss',
        'tax_hdmf',
        'tax_phic',
        'hdmf_loan',
        'sss_loan',
        'withholding_tax',
        'loan',
    ];
}
