<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayrollPeriod;

class PayrollPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_bmo = new PayrollPeriod;
        $new_bmo->frequency_id= 1;
        $new_bmo->year = 2022;
        $new_bmo->period_start = "2021-12-26";
        $new_bmo->period_end = "2022-01-10";
        $new_bmo->payout_date = "2022-01-15";
        $new_bmo->cutoff_order = 1;
        $new_bmo->is_payroll_generated = 0;
        $new_bmo->save();

        $new_bmo = new PayrollPeriod;
        $new_bmo->frequency_id= 1;
        $new_bmo->year = 2022;
        $new_bmo->period_start = "2022-01-11";
        $new_bmo->period_end = "2022-01-25";
        $new_bmo->payout_date = "2022-01-31";
        $new_bmo->cutoff_order = 2;
        $new_bmo->is_payroll_generated = 0;
        $new_bmo->save();

        // 1
        $new_wkl = new PayrollPeriod;
        $new_wkl->frequency_id= 2;
        $new_wkl->year = 2022;
        $new_wkl->period_start = "2021-12-31";
        $new_wkl->period_end = "2022-01-06";
        $new_wkl->payout_date = "2022-01-08";
        $new_wkl->cutoff_order = 1;
        $new_wkl->is_payroll_generated = 0;
        $new_wkl->save();
        // b
        $new_wkl = new PayrollPeriod;
        $new_wkl->frequency_id= 2;
        $new_wkl->year = 2022;
        $new_wkl->period_start = "2022-01-07";
        $new_wkl->period_end = "2022-01-13";
        $new_wkl->payout_date = "2022-01-15";
        $new_wkl->cutoff_order = 2;
        $new_wkl->is_payroll_generated = 0;
        $new_wkl->save();
        // c
        $new_wkl = new PayrollPeriod;
        $new_wkl->frequency_id= 2;
        $new_wkl->year = 2022;
        $new_wkl->period_start = "2022-01-14";
        $new_wkl->period_end = "2022-01-20";
        $new_wkl->payout_date = "2022-01-22";
        $new_wkl->cutoff_order = 3;
        $new_wkl->is_payroll_generated = 0;
        $new_wkl->save();
        // d
        $new_wkl = new PayrollPeriod;
        $new_wkl->frequency_id= 2;
        $new_wkl->year = 2022;
        $new_wkl->period_start = "2022-01-21";
        $new_wkl->period_end = "2022-01-27";
        $new_wkl->payout_date = "2022-01-29";
        $new_wkl->cutoff_order = 4;
        $new_wkl->is_payroll_generated = 0;
        $new_wkl->save();
    }
}
