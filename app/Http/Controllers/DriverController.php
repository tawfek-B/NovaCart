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

    public function fetchByDriverID($id) {
        return response()->json([
            'success' => Driver::where('id', $id)->first()?true:false,
            'driver' => Driver::where('id', $id)->first()
        ]);
    }
    public function fetchByUserID($id) {
        return response()->json([
            'success' => (User::where('id', $id)->first() && User::where('id', $id)->first()->isDriver)?true:false,
            'driver' => (User::where('id', $id)->first() && User::where('id', $id)->first()->isDriver)?User::where('id', $id)->first():null
        ]);
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

    public function create(Request $request)
    {

        $driverAttributes = [
            $name = $request->input('name'),
            $Location = $request->input('Location'),
            $isDelivering = $request->input('isDelivering')
        ];
        if(!is_null($request->file('image'))) {
            $path = $request->file('image')->store('drivers', 'public');
        }
        else {
            $path="drivers/default.png";
        }


        $driver = driver::factory()->create([
            'name' => $name,
            'Location' => $Location,
            'isDelivering' => $isDelivering
        ]);
    }

    public function update(Request $request, $id){


        $validated = [
            $name = $request->input('name'),
            $Location = $request->input('Location'),
            $isDelivering = $request->input('isDelivering')
        ];


            $driver = driver::where('id', $id)->first();

            $driver->name = $request->input('name');
            $driver->Location = $request->input('Location');
            $driver->isDelivering = $request->input('isDelivering');


            if(!is_null($request->file('image'))) {
                $path = $request->file('image')->store('drivers', 'public');
                if($driver->image!="drivers/default.png")
                Storage::delete($driver->image);
                $driver->image = str_replace('public\\', '', $path);//this replaces what's already in the user logo for the recently stored new pic
            }
            $driver->save();
    }

    public function delete(Request $request, $id) {
        $driver = driver::where('id', $id)->first();
        $name = $driver->name;
        $driver->delete();
        $i = 1;
        foreach(driver::all() as $driver) {
            $driver->id = $i;
            $driver->save();
            $i++;
        }
        $data = ['element' => 'store', 'id' => $id, 'name'=>$name];
        session( ['delete_info' => $data]);
        return redirect()->route('delete.confirmation');
    }
}
