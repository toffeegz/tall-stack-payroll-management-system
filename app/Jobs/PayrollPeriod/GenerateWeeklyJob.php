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
use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneratedPayrollPeriod;
use App\Models\PayrollPeriod;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Helper;

class GenerateWeeklyJob implements ShouldQueue
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
    private $modelService;
    private $modelRepository;
    public function handle(
        PayrollPeriodServiceInterface $modelService,
        PayrollPeriodRepositoryInterface $modelRepository,
    ) {
        $this->modelService = $modelService;
        $this->modelRepository = $modelRepository;
        Log::info('Generate Weekly Payroll Period started');
        $results = $this->generateWeekly();
        Log::info($results);
        Log::info('Generate Weekly Payroll Period ended');
    }

    public function generateWeekly()
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . ' 00:00:00');
        $year = $now->format('Y');

        $previous_record = PayrollPeriod::whereDate('period_end', '<', Carbon::now())
        ->where('frequency_id', PayrollPeriod::FREQUENCY_WEEKLY)
        ->latest('period_end')
        ->first();

        $today = new Carbon();
        if($today->dayOfWeek == Carbon::THURSDAY || $today->dayOfWeek == Carbon::FRIDAY || $today->dayOfWeek == Carbon::SATURDAY)
        {
            $last_period_start = Carbon::FRIDAY;
        } else {
            $last_period_start = Carbon::FRIDAY;
            $last_period_start = $last_period_start->copy()->subWeek();
        }

        $continue = true;
        if($previous_record) {
            $cutoff_start = $previous_record->cutoff_order == 2 ? 1:2;
            $first_period_start = Carbon::parse($previous_record->period_start)->next('FRIDAY'); 
            if($first_period_start->copy()->addWeek() == $last_period_start || $first_period_start > $today) {
                $continue = false;
            }
        } else {
            $first_period_start = $now->copy()->subMonth();
            $first_period_start = new Carbon('first FRIDAY of ' . $first_period_start->format('F') . ' ' . $first_period_start->format('Y'));
        }

        if($continue == true)
        {
            Log::info('continue nmn daw');
            
            Log::info('Date From:' . $first_period_start->format('Y-m-d'));
            Log::info('Date To:' . $last_period_start->format('Y-m-d'));
        }

        
    }
}
