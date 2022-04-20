<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SssContributionRate;

class SSSContributionRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sss_contribution_rate = new SssContributionRate;
        $sss_contribution_rate->ee_share = 4.5;
        $sss_contribution_rate->er_share = 8.5;
        $sss_contribution_rate->msc_min = 3000;
        $sss_contribution_rate->msc_max = 25000;
        $sss_contribution_rate->year = 2021;
        $sss_contribution_rate->save();
    }
}
