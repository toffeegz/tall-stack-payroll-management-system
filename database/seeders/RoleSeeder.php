<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Role $role)
    {
        $new_roles = [
            [
                'name' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Vestibulum efficitur nulla lectus, id euismod diam rhoncus vitae. ',
            ], [
                'name' => 'timekeeper',
                'display_name' => 'Timekeeper',
                'description' => 'Phasellus sem lectus, imperdiet at fermentum sit amet, molestie et urna. ',
            ]
        ];
        $role->insert($new_roles);

    }
}
