<?php

namespace App\Services\PayrollPeriod;

interface PayrollPeriodServiceInterface
{
    public function generateBiMonthly();
    public function bmCutoff($cutoff_order, $year, $month);
    public function store(array $params);
}
