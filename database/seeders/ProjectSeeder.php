<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $project_count = 100;
      for($i = 1; $i <= $project_count; $i++) {
        $data = Project::factory(1)->create();
      }

    }
}
