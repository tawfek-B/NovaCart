<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class NotificationsController extends Controller
{
    //
    public function cycleNotif(Request $request) {
        $userOrDriver = Auth::user();
        //// Get the user (assumed to be logged in or authenticated)
        // $user = Auth::user();

        // $user = User::where('notifications', 'delivered')->first();
        //     if ($user -> notifications=="delivered") {
        //         $user->notifications = null;
        //         $user->save();

        //         return null;
        //     }

        foreach (User::all() as $temp) {
            if ($temp->notifications == 'delivered') {
                $hasOtherOrders = false;//this code now checks if the user has other orders before setting his notifications value to either null(if there are no other orders),
                //or pending(if he has other orders)
                foreach(Order::all() as $order) {
                    if($order->user_id == $temp->id) {
                        $hasOtherOrders = true;
                    }
                }
                if($hasOtherOrders)
                $temp->notifications = "pending";
                else
                $temp->notifications = null;
                $temp->save();
                return response()->json((['success'=>true, 'status' => null]));
            }
        }
        if (is_null(Order::where('id', $request->input('orderID')))) {
            return response()->json((['success' => 'false']));
        }
        if (!($userOrDriver->isDriver) && ($userOrDriver->isAccepted)) {
            $OC = new OrderController();
            $notifications = [null, 'pending', 'accepted', 'delivering', 'delivered'];
            $currentNotification = $userOrDriver->notifications;
            $currentIndex = array_search($currentNotification, $notifications);
            if ($currentIndex == 3) {
                // echo(' has been delivered');
                $DriverController = new DriverController();
                if (is_null($DriverController->finishedDelivery($request))) {
                    return response()->json((['success' => 'false']));
                } else {
                    $userOrDriver->save();
                    $OC->delete($request);

                    $currentIndex++;
                    $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                    $userOrDriver->save();
                }
                    return response()->json((['success' => 'true', 'status' => $userOrDriver->notifications]));
                // return;
            }
            if($currentIndex == 1) {
                return response()->json((['success' => 'false']));
            }
            else {
                $currentIndex++;
                $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                $userOrDriver->save();
            }
            return response()->json((['success' => 'true', 'status' => $userOrDriver->notifications]));
        }
        else {
            if(!(Auth::user()->isDriver) && Auth::user()->notifcations!="pending") {
                // $this->line((['success'=>false]));
                return response()->json((['success' => 'true', 'status' => $userOrDriver->notifications]));
            }
            if ($userOrDriver) {
                $user = User::where('id', Order::where('id', $request->input('orderID'))->first()->user_id)->first();
                $OC = new OrderController();
                // echo ('loop');
                // Array of notification statuses in the desired order
                $notifications = [null, 'pending', 'accepted', 'delivering', 'delivered'];

                // Logic to cycle through the notifications
                // Get the current notification and find its index
                $currentNotification = $user->notifications;
                $currentIndex = array_search($currentNotification, $notifications);

                if ($currentIndex == 1) {
                    // echo(' is delivering');
                    $OC->accept($request);
                    $DriverController = new DriverController();
                    if (is_null($DriverController->makeDelivery($request, $userOrDriver))) {

                        $currentIndex++;
                        $user->notifications = $notifications[$currentIndex]; // Move to the next status
                        $user->save();
                    // $this->line((['success'=>true, 'status' => "accepted"]));
                    return response()->json((['success' => 'true', 'status' => 'Accepted Delivery']));
                    }
                    // Set the new notification status

                }
            } else {
                echo ('No authenticated user found.');
            }
        }
    }
}
