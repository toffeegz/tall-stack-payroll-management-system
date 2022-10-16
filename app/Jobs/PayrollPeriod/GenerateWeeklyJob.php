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
        Log::info('Generate Weekly Payroll Period ended');
    }

    // WEEKLY
    // period start at friday
    // period ends at thursday
    // payout date at saturday
    
    public function generateWeekly()
    {
        $today = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . ' 00:00:00');

        $previous_record = PayrollPeriod::whereDate('period_end', '<', $today)
        ->where('frequency_id', PayrollPeriod::FREQUENCY_WEEKLY)
        ->latest('period_end')
        ->first();

        if($previous_record) {
            $initial_first_period = Carbon::parse($previous_record->period_start)->addWeek()->startOfWeek();
        } else {
            $initial_first_period = $today->copy()->subMonth()->startOfWeek();
        }

        if($today->dayOfWeek == Carbon::THURSDAY || $today->dayOfWeek == Carbon::FRIDAY || $today->dayOfWeek == Carbon::SATURDAY || $today->dayOfWeek == Carbon::SUNDAY){
            $initial_last_period = $today->copy()->startOfWeek();
        } else {
            $initial_last_period = $today->copy()->subWeek()->startOfWeek();
        }

        $first_period = $initial_first_period->copy()->subDays(3);
        $last_period = $initial_last_period->copy()->subDays(3);

        $this->weeklyPeriod($first_period, $last_period);
    }

    public function weeklyPeriod($first_period, $last_period)
    {
        while($first_period < $last_period) {
            $payout_date = $first_period->copy()->addWeek()->addDays(8);
            $period_start = $first_period->copy()->addWeek();
            $period_end = $first_period->copy()->addWeek()->addDays(6);
            $this->modelRepository->firstOrCreate([
                'period_start' => $period_start->format('Y-m-d'),
                'period_end' => $period_end->format('Y-m-d'),
                'payout_date' => $payout_date->format('Y-m-d'),
            ], [
                'frequency_id' => PayrollPeriod::FREQUENCY_WEEKLY,
                'year' => $payout_date->format('Y'),
                'cutoff_order' => $period_end->weekNumberInMonth,
            ]);
            $first_period->addWeek();
        }
    }
}
