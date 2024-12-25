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
        return $order = Order::where('id', 1)->first();
    }

    public function fetchAll(Request $request)
    {
        return Order::all();
    }

    public function accept(Request $request)
    {
        if (User::where('id', 6)->first()->isDriver == true) {//test
            $order = Order::where('id', $request->input('orderID'))->first();
            $user = User::where('id', $order->user_id)->first();
            $user -> isAccepted = true;
            $order->isAccepted = true;
            $user->save();
            $order->save();
        }
    }

    public function delete(Request $request) {
        $order = Order::where('id', $request->input('orderID'))->first();
        $order->delete();
        $i=1;
        foreach(User::all() as $user) {
            $user->id = $i;
            $i++;
            $user->save();
        }
        // $order->isAccepted = false;
        // $order->save();
    }
}
