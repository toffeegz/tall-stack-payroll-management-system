<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\Project\ProjectServiceInterface;
use Carbon\Carbon;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    // private $modelService;
    // public function boot(e)
    // {
    //     $this->modelService = $modelService;
    // }

    public function definition()
    {
        $modelService = \App::make('App\Services\Project\ProjectServiceInterface');
        $code = $modelService->generateCode();
        $random_date = Carbon::today()->subDays(rand(0, 282));
        return [
            'name' => $this->faker->company(),
            'code' => $code,
            'start_date' => $random_date->copy()->subMonths(rand(1,12))->addDays(rand(1,15))->format('Y-m-d'),
            'end_date' => $random_date->format('Y-m-d'),
            'location' => $this->faker->address(),
            'details' => $this->faker->realText(200, $indexSize = 5),
            'status' => rand(1,3),
            'profile_photo_path' => $code . '.png',
        ];
    }
}
