<?php
namespace App\Http\Controllers;

use App\Events\OrderShipmentStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateShipmentStatus(Request $request)
    {
        $message = $request->input('message');
        $sender = $request->input('sender');

        // Broadcast the event
        broadcast(new OrderShipmentStatusUpdated($message, $sender));

        return response()->json(['status' => 'Shipment status broadcasted!']);
    }
}
