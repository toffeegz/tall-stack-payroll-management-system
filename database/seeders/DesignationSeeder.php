<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
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
                'id' => 1,
                'designation_name' => 'Project Manager',
                'department_id' => 1,
                'daily_rate' => '1500',
                'details' => 'Oversee the planning and delivery of construction projects. They ensure that work is completed on time and within budget.',
            ],
            [
                'id' => 5,
                'designation_name' => 'Laborer',
                'department_id' => 1,
                'daily_rate' => 700,
                'details' => ' cleans and prepares construction sites by removing debris or possible hazards and load building materials for use in a project and build scaffolds.',
            ],
            [
                'id' => 6,
                'designation_name' => 'Plumber',
                'department_id' => 1,
                'daily_rate' =>  700,
                'details' => 'Install, repair, and maintain pipes, valves, fittings, drainage systems, and fixtures in commercial and residential structures.',
            ],
            [
                'id' => 11,
                'designation_name' => 'Foreman',
                'department_id' => 1,
                'daily_rate' => 456,
                'details' => 'take the lead on construction projects, holding daily meetings with employees, reminding them of safety protocols and resolving problems and conflicts that may arise.',
            ],
            [
                'id' => 2,
                'designation_name' => 'Human Resource Manager',
                'department_id' => 2,
                'daily_rate' => 2000,
                'details' => 'They oversee the recruiting, interviewing, and hiring of new staff; consult with top executives on strategic planning; and serve as a link between an organizations management and its employees.',
            ],
            [
                'id' => 3,
                'designation_name' => 'Full Stack Developer',
                'department_id' => 3,
                'daily_rate' => 685.8,
                'details' => 'they provide an end-to-end service, and can be involved in projects that involve databases and building user-facing websites',
            ],
        ];

        Designation::insert($data);
        
    }
}
