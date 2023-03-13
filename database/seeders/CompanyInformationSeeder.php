<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyInformation;

class CompanyInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(CompanyInformation $companyInformation)
    {
        CompanyInformation::truncate();
        CompanyInformation::factory(1)->create();
    }
}
