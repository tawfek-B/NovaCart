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

        $storeAttributes =[
            $name = $request->input('name'),
            $openingTime = $request->input('openingTime'),
            $closingTime = $request->input('closingTime'),
            $location = $request->input('location'),
            $deliveryFee = $request->input('deliveryFee'),
            $distance = $request->input('distance'),
        ];
        $store = Store::factory()->create([
            'name' => $name,
            'opening time' => $openingTime,
            'closing time' => $closingTime,
            'location' => $location,
            'delivery fee' => $deliveryFee,
            'distance' => $distance,
        ]);

    }
}
