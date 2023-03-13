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
        $companyInformation->create([
            'name' => 'Aero-Kim Builders',
            'address' => 'Silver Road Brgy. Epifanio Malia, General Mariano Alvarez, 4117 Cavite',
            'phone' => '(046) 414 6885',
            'email' => 'aerokim.builders@gmail.com',
            'logo_path' => 'aerokim.png',
        ]);
    }
}
