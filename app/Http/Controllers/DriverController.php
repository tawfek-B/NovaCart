<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{

    public function fetchByDriverID($id)
    {
        return response()->json([
            'success' => Driver::where('id', $id)->first() ? true : false,
            'driver' => Driver::where('id', $id)->first()
        ]);
    }
    public function fetchByUserID($id)
    {
        return response()->json([
            'success' => (User::where('id', $id)->first() && User::where('id', $id)->first()->isDriver) ? true : false,
            'driver' => (User::where('id', $id)->first() && User::where('id', $id)->first()->isDriver) ? User::where('id', $id)->first() : null
        ]);
    }
    public function makeDelivery(Request $request, User $user)
    {
        if (is_null(Order::where('id', $request->input('orderID'))->first())) {
            return null;
        }
        // dd($user->isDriver);
        if (($user->isDriver) == 0) {
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

    public function finishedDelivery(Request $request)
    {
        if (is_null(Order::where('id', $request->input('orderID'))->first())) {
            return null;
        }
        $deliveryUser = User::where('id', Order::where('id', $request->input('orderID'))->first()->driver_id)->first();//test
        if (!($deliveryUser->isDriver)) {
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
        $numberRepeated = false;
        $nameRepeated = false;
        $emailRepeated = false;
        foreach (Driver::all() as $driver) {
            $user = User::where('id', $driver->user_id)->first();
            if ($user->number == $request->input('number')) {
                $numberRepeated = true;
            }

            if ($user->email == $request->input('email')) {
                $emailRepeated = true;
            }

            if ($driver->name == $request->input('userName')) {
                $nameRepeated = true;
            }
        }

        if ($numberRepeated && $nameRepeated && $emailRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'User name has already been taken',
                'number' => 'Number has already been taken',
                'email' => 'Email has already been taken',
            ]);
        }

        if($numberRepeated && $nameRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'User ame has already been taken',
                'number' => 'Number has already been taken',
            ]);
        }

        if($emailRepeated && $nameRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'User name has already been taken',
                'email' => 'Email has already been taken',
            ]);
        }

        if($numberRepeated && $emailRepeated) {
            return redirect()->back()->withErrors([
                'email' => 'Email has already been taken',
                'number' => 'Number has already been taken',
            ]);
        }

        if ($numberRepeated) {
            return redirect()->back()->withErrors([
                'number' => 'Number has already been taken',
            ]);
        }

        if ($nameRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'User name has already been taken',
            ]);
        }

        if ($emailRepeated) {
            return redirect()->back()->withErrors([
                'email' => 'Email has already been taken',
            ]);
        }

        if (!is_null($request->file('image'))) {
            $path = $request->file('image')->store('Drivers', 'public');
        } else {
            $path = "Drivers/default.png";
        }

        $user = User::create([
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'userName' => $request->input('userName'),
            'logo' => $path,
            'location' => $request->input('location'),
            'password' => Hash::make($request->input('password')),
            'number' => $request->input('number'),
            'email' => $request->input('email'),
            'isAccepted' => false,
            'isDriver' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $driverAttributes = [
            $name = $request->input('userName'),
            $Location = $request->input('location'),
            $isDelivering = false
        ];

        $driver = driver::factory()->create([
            'name' => $name,
            'Location' => $Location,
            'image' => $path,
            'isDelivering' => $isDelivering,
            'user_id' => $user->id,
        ]);
        $data = ['element' => 'driver', 'id' => $driver->id, 'name' => $driver->name];
        session(['add_info' => $data]);
        return redirect()->route('add.confirmation');
    }

    public function update(Request $request, $id)
    {
        $numberRepeated = false;
        $nameRepeated = false;
        foreach (Driver::all() as $driver) {
            $user = User::where('id', $driver->user_id)->first();
            if ($driver->name == $request->input('userName') && $user->number == $request->input('number') && $driver->id != $id) {
                $numberRepeated = true;
                $nameRepeated = true;
            }
            if ($user->number == $request->input('number') && $driver->id != $id) {
                $numberRepeated = true;
            }
            if ($driver->name == $request->input('userName') && $driver->id != $id) {
                $nameRepeated = true;
            }
        }

        if ($numberRepeated && $nameRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'Name has already been taken',
                'number' => 'Number has already been taken',
            ]);
        }

        if ($numberRepeated) {
            return redirect()->back()->withErrors([
                'number' => 'Number has already been taken',
            ]);
        }

        if ($nameRepeated) {
            return redirect()->back()->withErrors([
                'userName' => 'Name has already been taken',
            ]);
        }

        $driver = driver::where('id', $id)->first();

        $user = User::where('id', $driver->user_id)->first();


        $driver->name = $request->input('userName');
        $driver->location = $request->input('location');

        // $driver->isDelivering = $request->input('isDelivering');     //why would we change isDelivering?


        if (!is_null($request->file('image'))) {
            $path = $request->file('image')->store('drivers', 'public');
            if ($driver->image != "Drivers/default.png")
                Storage::delete($driver->image);
            $driver->image = str_replace('public\\', '', $path);//this replaces what's already in the user logo for the recently stored new pic
            $user->logo = str_replace('public\\', '', $path);
        }

        if (!is_null($request->input('password')))
            $user->password = Hash::make($request->input('password'));

        $user->userName = $request->input('userName');
        $user->location = $request->input('location');
        $user->number = $request->input('number');
        $user->save();
        $driver->save();
        $data = ['element' => 'driver', 'id' => $id, 'name' => $driver->name];
        session(['update_info' => $data]);
        return redirect()->route('update.confirmation');
    }

    public function delete(Request $request, $id)
    {
        $driver = driver::where('id', $id)->first();
        $userID = $driver->user_id;
        $name = $driver->name;
        $driver->delete();
        User::where('id', $userID)->first()->delete();
        $i = 1;
        foreach (driver::all() as $driver) {
            $driver->id = $i;
            $driver->save();
            $i++;
        }
        // $i = 1;
        // foreach (User::all() as $user) {
        //     $user->id = $i;
        //     $user->save();
        //     $i++;
        // }        //if we want to do this we have to change the user_id in all drivers
        $data = ['element' => 'store', 'id' => $id, 'name' => $name];
        session(['delete_info' => $data]);
        return redirect()->route('delete.confirmation');
    }
}
