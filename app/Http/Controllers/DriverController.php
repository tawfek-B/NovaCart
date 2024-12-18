<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function makeDelivery()
    {
        $isDelivering = Driver::where('isDelivering', false)->inRandomOrder()->first();
        if ($isDelivering) {
            $isDelivering->isDelivering = true;
            $isDelivering->save();
            echo "isDelivering updated";
        } else {
            echo "No isDelivering found to be false";
        }
    }
}
