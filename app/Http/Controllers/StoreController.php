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

        if(!is_null($request->file('image'))) {
            $path = $request->file('image')->store('Stores', 'public');
        }
        else {
            $path="Stores/default.png";
        }
        $store = Store::factory()->create([
            'name' => $name,
            'description' => $description,
            'openingTime' => $openingTime,
            'closingTime' => $closingTime,
            'image' => $path,
            'location' => $location,
        ]);

    }

    public function update(Request $request, $id) {

        $validated = $request->validate(rules: [
            'name' => 'required',
            'openingTime' => 'required',
            'closingTime' => 'required',
            'location' => 'required',
            'description' => 'required',
        ]);

        $store = Store::where('id', $id)->first();
        // dd($store, 'auhswfhawusfwas');

        if(!is_null($request->file('image'))) {
            $path = $request->file('image')->store('Stores', 'public');
            $store->image = str_replace('public\\', '', $path);//this replaces what's already in the user logo for the recently stored new pic
        }
        // dd($store->name);
        // dd($request->input('name'));
        $store->name = $request->input('name');
        $store->openingTime = $request->input('openingTime');
        $store->closingTime = $request->input('closingTime');
        $store->description = $request->input('description');
        $store->location = $request->input('location');
        $store->save();
        // $store = 'sto' === 1;
            // return response()->json([
            //     'message' => 'Store updated successfully',
            //     'data' => $store,
            // ], 200);

    }

    public function fetch(Request $request) {

        return Store::where('id', $request->input('storeID'))->first();
    }

    public function fetchAll() {
        return Store::all();
    }

}
