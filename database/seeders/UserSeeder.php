<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Designation;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'email' => 'gezrylclarizg@gmail.com',
            'password' => Hash::make('password'),
            'last_name' => 'Gallego',
            'first_name' => 'Gezryl',
            'middle_name' => 'Beato',
            'code' => '2022-0001',
            'phone_number' => '0975935907',
            'birth_date' => '1999-05-27',
            'birth_place' => 'Binan, Laguna',
            'fathers_name' => 'Fernando Gallego',
            'mothers_name' => 'Rosalinda Beato',
            'gender' => 1,
            'marital_status' => 1,
            'nationality' => 'Filipino',
            'address' => 'Gma, Cavite',
            'employment_status' => 1,
            'is_active' => true,
            'is_paid_holidays' => true,
            'is_tax_exempted' => false,
            'frequency_id' => 1,
        ];

        $user = User::create($user);
        $user->attachRole(Role::ADMINISTRATOR_ID);
        $user->designations()->attach([Designation::FULL_STACK_DEVELOPER_ID]);
    }
}
