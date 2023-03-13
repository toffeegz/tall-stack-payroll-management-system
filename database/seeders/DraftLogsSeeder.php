<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DraftLogs;

class DraftLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'code' => 2,
                'name' => 'Default User System Access',
                'value' => true,
            ],
        ];

        foreach($data as $value) {
            DraftLogs::insert($value);
        }

    }
}
