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

    public function fetchByDriverID(Request $request) {
        return Driver::where('id', $request->input('driverID'))->first();
    }
    public function fetchByUserID(Request $request) {
        return Driver::where('user_id', $request->input('driverID'))->first();
    }
    public function makeDelivery(Request $request, User $user)
    {
        if(is_null(Order::where('id', $request->input('orderID'))->first())) {
            return null;
        }
        // dd($user->isDriver);
        if(($user->isDriver) == 0) {
            return response()->json([
                'success' => 'false',
            ]);
        }
        $deliveryUser = Auth::user();//test
        $driver = Driver::where('user_id', $deliveryUser->id)->first();
        if ($deliveryUser) {
            $order = Order::where('id', $request->input('orderID'))->first();
            $order->driver_id = $deliveryUser->id;
            $order->save();
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
        if(is_null(Order::where('id', $request->input('orderID'))->first())) {
            return null;
        }
        $deliveryUser = User::where('id', Order::where('id', $request->input('orderID'))->first()->driver_id)->first();//test
        if(!($deliveryUser->isDriver)) {
            return response()->json([
                'success' => 'false',
            ]);
        }
        $driver = Driver::where('user_id', $deliveryUser->id)->first();
        if ($deliveryUser) {
            $driver->isDelivering = false;
            $driver->save();
            $user = User::where('id', Order::where('id', $request->input('orderID'))->first()->user_id)->first();
            $user->isAccepted = false;
            $user->notifications = 'delivered';
            $user->save();
            return 1;
        } else {
            echo "No isDelivering found to be false";
        }
    }
}
