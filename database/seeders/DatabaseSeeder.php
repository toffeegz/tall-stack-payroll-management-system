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
        $this->call([
            CompanyInformationSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            // DraftLogsSeeder::class,
            EarningSeeder::class,
            GrossTypeSeeder::class,
            HDMFContributionRateSeeder::class,
            // LeaveSeeder::class,
            LeaveTypeSeeder::class,
            PayrollPeriodSeeder::class,
            PHICContributionRateSeeder::class,
            ProjectSeeder::class,
            RoleSeeder::class,
            ScheduleSeeder::class,
            SSSContributionModelSeeder::class,
            SSSContributionRateSeeder::class,
            UserSeeder::class,
        ]);
    }
}
