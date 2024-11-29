<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('Running StoreSeeder');
        Store::factory()->count(10)->create()->each(function ($store) {
            Log::info('Created Store: ' . $store->id);
            Product::factory()->count(5)->create(['store_id' => $store->id]); // Create products linked to the store
        });
    }
}
