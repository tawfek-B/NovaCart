<?php
namespace App\Http\Controllers;

use App\Events\OrderShipmentStatusUpdated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function fetch(Request $request)
    {
        return $order = Order::where('id', $request->input('orderID'))->first();
    }

    public function fetchAll(Request $request)
    {
        return Order::all();
    }

    public function accept(Request $request)
    {
        if (is_null($order = Order::where('id', $request->input('orderID'))->first())) {
            return response()->json([
                'success' => 'false',
            ]);
        }
        if (Auth::user()->isDriver == true) {//test
            $order = Order::where('id', $request->input('orderID'))->first();
            $user = User::where('id', $order->user_id)->first();
            $user->isAccepted = true;
            $order->isAccepted = true;
            $user->save();
            $order->save();
        }


    }

    public function deliveredOrder(Request $request)
    {//might make some changes here so the user notification will turn into delivered. since the driver will click on a button to confirm the delivery has been.... delivered

    }

    public function delete(Request $request)
    {
        $order = Order::where('id', $request->input('orderID'))->first();
        $order->delete();
        $i = 1;
        foreach (User::all() as $user) {
            $user->id = $i;
            $i++;
            $user->save();
        }

        $orders = Order::orderBy('id')->get();
        foreach ($orders as $index => $order) {
            $order->update(['id' => $index + 1]);
        }

        // $order->isAccepted = false;
        // $order->save();
    }
}
