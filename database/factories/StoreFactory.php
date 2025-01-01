<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $openingTime = fake()->time();//did this because in line 24, when writing 'closing time' => (Carbon::parse('opening time').....etc it reads the string instead of the time
        return [
            'name' => fake()->domainName(),
            'openingTime' => fake()->time(),
            'closingTime' => (Carbon::parse($openingTime)->addHours(rand(1,10)))->format('H:i:s'),//this basically turns the string to a "time" variable to be able to add hours to it and turn it to a certain format, not using format adds a date to the time variable.
            //this isn't neccessary, as this is just used for seeding, not for the actual app, I'm just testing shit out and trying to make the 'opening hours' and 'closing hours' work.
            'image' => 'Users/default.png',
            'description' => fake()->text(),
            'location' => fake()->streetName(),
        ];
    }
}
