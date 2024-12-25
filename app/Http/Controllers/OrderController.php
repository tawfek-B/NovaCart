<?php
namespace App\Http\Controllers;

use App\Events\OrderShipmentStatusUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function fetch(Request $request)
    {
        return Order::where('id', operator: $request->input('productID'))->first();
    }

    public function fetchAll(Request $request)
    {
        return Order::all();
    }

    public function accept()
    {
        if (Auth::user()->isDriver == true) {
            Order::where('user_id', Auth::user()->id)->isAccepted = true;
        }
    }
}
