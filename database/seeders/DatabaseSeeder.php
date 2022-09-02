<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(Seeder::class);
        $this->call(CompanyInformationSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(DraftLogsSeeder::class);
        $this->call(EarningSeeder::class);
        $this->call(GrossTypeSeeder::class);
        $this->call(HDMFContributionRateSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(PayrollPeriodSeeder::class);
        $this->call(PHICContributionRateSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SSSContributionModelSeeder::class);
        $this->call(SSSContributionRateSeeder::class);
        $this->call(UserSeeder::class);
    }
}
