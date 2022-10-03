<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::updateOrCreate([
            'id' => 1
        ],[
            'code' => 'DEFAULT',
            'name' => 'Default',
            'time_in' => '07:00',
            'time_out' => '15:00',
            'lunch_time' => '12:00',
            'working_days' => json_encode($this->workingDays()),
        ]);
    }

    public function workingDays()
    {
        return [
            'sunday' => false,
            'monday' => true,
            'tuesday' => true,
            'wednesday' => true,
            'thursday' => true,
            'friday' => true,
            'saturday' => false,
        ];
    }
}
