<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use App\Models\Designation;
use Illuminate\Support\Facades\DB;
use App\Models\PayrollPeriod;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // INITIAL ADMINISTRATOR
            $new_code = '2022-0001';
            $user = [
                'email' => 'admin@admin.com',
                'email_verified_at' => \Carbon\Carbon::now(),
                'password' => Hash::make('password'),
                'last_name' => 'Gallego',
                'first_name' => 'Gezryl',
                'middle_name' => 'test',
                'code' => $new_code,
                'phone_number' => '0975935907',
                'birth_date' => 'test',
                'birth_place' => 'test',
                'fathers_name' => 'test',
                'mothers_name' => 'test',
                'gender' => 1,
                'marital_status' => 1,
                'nationality' => 'Filipino',
                'address' => 'test',
                'employment_status' => 1,
                'is_active' => true,
                'is_paid_holidays' => true,
                'is_tax_exempted' => false,
                'frequency_id' => 1,
                'profile_photo_path' => $new_code . ".png",
            ];

            $user = User::create($user);
            $user->attachRole(Role::ADMINISTRATOR_ID);
            $user->designations()->attach([Designation::FULL_STACK_DEVELOPER_ID]);
        //

        // GENERATED
            // BIMONTHLY USER
                $designation_ids_bmo = [12, 13];
                $total_user_bmo = 50;
                for($i = 1;$i <= $total_user_bmo; $i++) {
                    $user = User::factory(1)->create();
                    $user = $user[0];
                    $rand_des_id = rand(0,1);
                    $designation_id = $designation_ids_bmo[$rand_des_id];
                    $user->frequency_id = PayrollPeriod::FREQUENCY_BIMONTHLY;
                    $user->designations()->attach([$designation_id]);
                    $user->save();
                }
            // 

            // WEEKLY USER
                $designation_ids_wkl = [11, 6, 5];
                $total_user_wkl = 50;
                for($i = 1;$i <= $total_user_wkl; $i++) {
                    
                    $user = User::factory(1)->create();
                    $user = $user[0];
                    $rand_des_id = rand(0,1);
                    $designation_id = $designation_ids_wkl[$rand_des_id];
                    $user->frequency_id = PayrollPeriod::FREQUENCY_BIMONTHLY;
                    $user->designations()->attach([$designation_id]);
                    $user->save();
                }
            //
        //
    }
}
