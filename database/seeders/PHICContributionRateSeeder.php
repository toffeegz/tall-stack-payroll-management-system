<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhicContributionRate;
use Carbon\Carbon;

class PHICContributionRateSeeder extends Seeder
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
                'premium_rate' => 4,
                'mbs_min' => 0,
                'mbs_max' => 10000,
            ],
            [
                'year' => Carbon::now()->format('Y'),
                'premium_rate' => 4,
                'mbs_min' => 1000.01,
                'mbs_max' => 79999.99,
            ],
            [
                'year' => Carbon::now()->format('Y'),
                'premium_rate' => 4,
                'mbs_min' => 80000.00,
                'mbs_max' => 0,
            ]
        ];
        PhicContributionRate::insert($collection);
    }
}
