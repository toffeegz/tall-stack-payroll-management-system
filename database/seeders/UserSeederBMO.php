<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayrollPeriod;
use App\Models\User;

class UserSeederBMO extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        // // bimonthly
        // $designation_ids_bmo = [12, 13];
        // $users_bmo = User::factory(50)->create();
        // foreach($users_bmo as $user) {
        //     $rand_des_id = rand(0,1);
        //     $designation_id = $designation_ids_bmo[$rand_des_id];
        //     $user = User::find($user->id);
        //     $user->frequency_id = PayrollPeriod::FREQUENCY_BIMONTHLY;
        //     $user->designations()->attach([$designation_id]);
        //     $user->save();
        // }

        // // weekly
        // $designation_ids_wkl = [11, 6, 5];
        // $users_wkl = User::factory(50)->create();
        // foreach($users_bmo as $user) {
        //     $rand_des_id = rand(0,1);
        //     $designation_id = $designation_ids_wkl[$rand_des_id];
        //     $user = User::find($user->id);
        //     $user->frequency_id = PayrollPeriod::FREQUENCY_WEEKLY;
        //     $user->designations()->attach([$designation_id]);
        //     $user->save();
        // }
        
    }
}
