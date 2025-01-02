<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //

    public function create(Request $request) {

        // $request->validate([
        //     'name' => 'required',
        //     'opening hours' => 'required',
        //     'location' => 'required',
        //     'delivery fee' => 'required',
        //     'distance' => 'required',
        // ]);

        //for some reason, putting 'required' on these causes postman to return a redirection to "novacart.test"

        $storeAttributes = [
            $name = $request->input('name'),
            $description = $request->input('description'),
            $openingTime = $request->input('openingTime'),
            $closingTime = $request->input('closingTime'),
            $location = $request->input('location'),
        ];
        $store = Store::factory()->create([
            'name' => $name,
            'description' => $description,
            'openingTime' => $openingTime,
            'closingTime' => $closingTime,
            'location' => $location,
        ]);

    }

    public function update(Request $request) {

        $validated = $request->validate(rules: [
            'name' => 'required',
            'openingTime' => 'required',
            'closingTime' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);

            $store = Store::where('id', $request->input('storeID'))->first();

            $store->update($validated);

            return response()->json([
                'message' => 'Store updated successfully',
                'data' => $store,
            ], 200);

    }

    public function fetch(Request $request) {

        return Store::where('id', $request->input('storeID'))->first();
    }

    public function fetchAll() {
        return Store::all();
    }

}
