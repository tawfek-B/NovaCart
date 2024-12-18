<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory(10)->create();
        $this->call(StoreSeeder::class);

        Driver::factory(10)->create();
        User::create([
            'firstname' => 'hi',
            'lastname' => fake()->lastName(),
            'userName' => fake()->name(),
            'number' => fake()->phoneNumber(),
            'admin' => false,
            'email' => fake()->unique()->safeEmail(),
            'password' => '12345678',
            'email_verified_at' => now(),
            'logo' => fake()->imageUrl(),
            'location' => fake()->streetAddress(),
        ]);
    }
}
