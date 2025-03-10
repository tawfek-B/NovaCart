<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cart =[];
        $itemCount = rand(1,5);
        for($i  = 0; $i<5; $i++) {
            $cart[] = [
                'product_id' => fake()->unique()->numberBetween(1,100),
                'quantity' => fake()->numberBetween(1,100),
            ];
        }
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'userName' => fake()->name(),
            'number' => fake()->phoneNumber(),
            'admin' => false,
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= bcrypt('password'),
            'email_verified_at' => now(),
            'logo' => 'Users/default.png',
            'location' => fake()->streetAddress(),
            'notifications' => null,
            'isDriver' => rand(0,1),
            'isAccepted' => 0,
            // 'remember_token' => Str::random(10),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
