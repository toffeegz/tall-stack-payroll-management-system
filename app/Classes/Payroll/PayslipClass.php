<?php

namespace App\Classes\Payroll;

use App\Jobs\Payroll\PayslipJob;

class PayslipClass {

    public function payslipCreation($data)
    {
        foreach($data as $payslip)
        {
            PayslipJob::dispatch($payslip)
            ->delay(now()->addSeconds(15));
        }

        return 'success';
    }
}