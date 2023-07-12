<?php

namespace App\Services\Payroll;

interface PayrollServiceInterface
{
    public function previewPayrollByUser($user, $period_start, $period_end);
}
