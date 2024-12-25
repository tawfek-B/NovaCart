<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    //  return [
    //     'name' => fake()->name(),
    //     'location' => fake()->streetAddress(),
    //     'isDelivering' => false,
    // ];
    public function definition(): array
    {
        return [
            'user_id' => rand(0,1000),
            'name' => fake()->name(),
            'location' => fake()->streetAddress(),
            'isDelivering' => 0,
        ];

    }

}
