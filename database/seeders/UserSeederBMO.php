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
        $designation_ids = [12, 13];
        
        $users = User::factory(50)->create();
        foreach($users as $user) {
            $rand_des_id = rand(0,1);
            $designation_id = $designation_ids[$rand_des_id];
            $user = User::find($user->id);
            $user->frequency_id = PayrollPeriod::FREQUENCY_BIMONTHLY;
            $user->designations()->attach([$designation_id]);
            $user->save();
        }
    }
}
