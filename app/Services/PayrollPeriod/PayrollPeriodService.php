<?php

namespace App\Services\PayrollPeriod;

use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneratedPayrollPeriod;
use App\Models\PayrollPeriod;
use App\Models\Role;
use Carbon\Carbon;

class PayrollPeriodService implements PayrollPeriodServiceInterface
{
    private PayrollPeriodRepositoryInterface $modelRepository;

    public function __construct(
        PayrollPeriodRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function mailToAdmin($frequency, $payout_dates)
    {
        $freq_str = $frequency  == PayrollPeriod::FREQUENCY_BIMONTHLY ? "Bi-Monthly":"Weekly";
        $message = "Created ". $freq_str ." Periods with a payout date:";
        $admins = Role::find(Role::ADMINISTRATOR_ID)->users;

        $dates = [];
        foreach($payout_dates as $payout_date) {
            $dates[] = Carbon::parse($payout_date)->format('F d, Y');
        }

        foreach($admins as $admin) {
            Mail::to($admin->email)->send(new GeneratedPayrollPeriod($message, $dates));
        }
        Log::info('Generate Payroll Period Mail has been sent successfully to admins');
    }
}