<?php

namespace App\Jobs\Payslip;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\Payslip\PayslipServiceInterface;

class GeneratePayslipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $data;
    private $modelService;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle(
        PayslipServiceInterface $modelService,
    )
    {
        $this->modelService = $modelService;

        Log::info('Generate Payslip started');
        $results = $this->modelService->generate($this->data);
        Log::info('Generate Payslip ended');
    }
}
