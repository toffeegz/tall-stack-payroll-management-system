<?php

namespace App\Services\PayrollPeriod;

interface PayrollPeriodServiceInterface
{
    public function mailToAdmin($frequency, $payout_dates);
    public function payroll($data);
    public function getSSSContributionAmount($salary);
    public function getHDMFContributionAmount($monthly_basic_salary);
    public function getPHICContributionAmount($monthly_basic_salary);
    public function getTotalDaysPresentOrLate($user_id, $between_dates);
    public function getTotalPaidLeaveHours($user_id, $between_dates);
    public function getTotalAbsencesTardinesss($between_dates, $data);
}
