<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;

class HelperController extends Controller
{
    private $payrollPeriodService;
    public function __construct(
        PayrollPeriodServiceInterface $payrollPeriodService
    ) {
        $this->payrollPeriodService = $payrollPeriodService;
    }

    public function generatePayrollPeriod()
    {
        return $this->payrollPeriodService->generateBiMonthly();
    }
}
