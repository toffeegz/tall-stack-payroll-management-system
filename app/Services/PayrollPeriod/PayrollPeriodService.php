<?php

namespace App\Services\PayrollPeriod;

use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;

class PayrollPeriodService implements PayrollPeriodServiceInterface
{
    private PayrollPeriodRepositoryInterface $modelRepository;

    public function __construct(
        PayrollPeriodRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    
}