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

        User::create([
            'firstname' => 'hi',
            'lastname' => fake()->lastName(),
            'userName' => fake()->name(),
            'number' => 12345678,
            'admin' => false,
            'email' => fake()->unique()->safeEmail(),
            'password' => '12345678',
            'email_verified_at' => now(),
            'logo' => fake()->imageUrl(),
            'location' => fake()->streetAddress(),
            'isAccepted' => 0,
            'isDriver' => 1,
        ]);
        foreach(User::all() as $user) {//this iterates through all the users to check which one is a driver to create an instance of the Driver model
            if($user->isDriver) {
                Driver::factory()->create([
                    'user_id' => $user->id,
                    'name' => $user->userName,//Maybe change this so it takes both the first and last name instead of the username? Or maybe add a first, last and username for the driver model?
                    'location' => $user->location,
                    'isDelivering' => 0,
                ]);
            }
        }
    }
}
