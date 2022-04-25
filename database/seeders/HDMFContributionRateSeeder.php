<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HdmfContributionRate;
use Carbon\Carbon;

class HDMFContributionRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = [
            [
                'year' => Carbon::now()->format('Y'),
                'er_share' => 2,
                'ee_share' => 1,
                'msc_min' => 1000,
                'msc_max' => 1500,
            ],
            [
                'year' => Carbon::now()->format('Y'),
                'er_share' => 2,
                'ee_share' => 2,
                'msc_min' => 1500,
                'msc_max' => 0,
            ]
        ];
        HdmfContributionRate::insert($collection);
    }
}
