<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DriverController extends Controller
{
    public function makeDelivery(Request $request)
    {
        $deliveryUser = User::find(6);//test
        $driver = Driver::where('user_id', $deliveryUser->id)->first();
        if ($deliveryUser) {
            $driver->isDelivering = true;
            $driver->save();
            $user = User::where('id', Order::where('id', $request->input('orderID'))->first()->user_id)->first();
            $user->isAccepted = true;
            $user->save();
        } else {
            echo "No isDelivering found to be false";
        }
    }

    public function finishedDelivery(Request $request) {
        $deliveryUser = User::find(6);//test
        $driver = Driver::where('user_id', $deliveryUser->id)->first();
        if ($deliveryUser) {
            $driver->isDelivering = false;
            $driver->save();
            $user = User::where('id', Order::where('id', $request->input('orderID'))->first()->user_id)->first();
            $user->isAccepted = false;
            $user->save();
        } else {
            echo "No isDelivering found to be false";
        }
    }
}
