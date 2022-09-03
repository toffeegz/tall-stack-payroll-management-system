<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();
        $data = [
            [
                'id' => 1,
                'department_name' => 'Construction',
            ],
            [
                'id' => 2,
                'department_name' => 'Human Resource',
            ],
            [
                'id' => 3,
                'department_name' => 'Information Technology',
            ]
        ];
        Department::insert($data);
    }
}
