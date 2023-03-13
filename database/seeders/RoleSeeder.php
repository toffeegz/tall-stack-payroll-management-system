<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Role $role)
    {
        $roles = [
            [
                'id' => Role::ADMINISTRATOR_ID,
                'name' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Vestibulum efficitur nulla lectus, id euismod diam rhoncus vitae. ',
            ], [
                'id' => Role::TIMEKEEPER_ID,
                'name' => 'timekeeper',
                'display_name' => 'Timekeeper',
                'description' => 'Phasellus sem lectus, imperdiet at fermentum sit amet, molestie et urna. ',
            ]
        ];

        foreach($roles as $role) {
            Role::updateOrCreate(['id'=>$role['id']],[
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'description' => $role['description'],
            ]);
        }

    }
}
