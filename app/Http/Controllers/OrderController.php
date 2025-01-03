<?php
namespace App\Http\Controllers;

use App\Events\OrderShipmentStatusUpdated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function fetch(Request $request, $id)
    {
        return response()->json([
            'success' => Order::where('id', $id)->first()?true:false,
            'order' =>  Order::where('id', $id)->first(),
        ]);
    }

    public function fetchID() {//sends the id of the order made by the current user and that isAccepted
        $userID = Auth::id();
        foreach(Order::all() as $order) {
            if($order->user_id == $userID && $order->isAccepted) {
                return response()->json([
                    'order_id' => $order->id,
                ]);
            }
        }
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
            $order->save();
        }
        return response()->json([
            'success' => 'true',
        ]);

        // $order->isAccepted = false;
        // $order->save();
    }
}
