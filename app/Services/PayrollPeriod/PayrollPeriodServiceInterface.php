<?php

namespace App\Services\PayrollPeriod;

interface PayrollPeriodServiceInterface
{
    public function mailToAdmin($frequency, $payout_dates);
}
