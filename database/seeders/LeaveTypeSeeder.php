<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(LeaveType $leaveType)
    {
        $data = [
            [
                'name' => 'Vacation Leave',
                'days' => '15',
                'is_active' => true,
            ], [
                'name' => 'Sick Leave',
                'days' => '15',
                'is_active' => true,
            ], [
                'name' => 'Maternity Leave',
                'days' => '30',
                'is_active' => true,
            ], [
                'name' => 'Paternity Leave',
                'days' => '7',
                'is_active' => true,
            ]
        ];

        $leaveType->insert($data);

    }
}
