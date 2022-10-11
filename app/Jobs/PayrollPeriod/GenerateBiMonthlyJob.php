<?php

namespace App\Jobs\PayrollPeriod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;

class GenerateBiMonthlyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PayrollPeriodServiceInterface $modelService)
    {
        Log::info('Generate Bi-Monthly Payroll Period started');
        $results = $modelService->generateBiMonthly();
        Log::info($results);
        Log::info('Generate Bi-Monthly Payroll Period ended');
    }
}
