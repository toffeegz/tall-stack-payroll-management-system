<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Helper;
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $latest_user = User::orderBy('code', 'desc')->first();
        $latest_code = $latest_user->code;
        $last_digits = substr($latest_code, 6) + 1;
        $new_code = Helper::generateCode($last_digits);

        return [
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'code' => $new_code,
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->unique()->e164PhoneNumber(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $startDate = '-40 years', $endDate = '-20 years'),
            'birth_place' => $this->faker->address(),
            'fathers_name' => $this->faker->name(),
            'mothers_name' => $this->faker->name(),
            'gender' => rand(1,2),
            'marital_status' => rand(0,3),
            'nationality' => 'Filipino',
            'address' => $this->faker->address(),
            'employment_status' => rand(1,5),
            'is_active' => true,
            'is_paid_holidays' => rand(0,1),
            'is_tax_exempted' => false,
            'system_access' => true,
            // 'frequency_id' => rand(1,2),
            'profile_photo_path' => $new_code . ".png",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
