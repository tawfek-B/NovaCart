<?php

namespace App\Console\Commands;

use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class UpdateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-notifications {userID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {
        $userID = $this->argument('userID');
        $userOrDriver = User::find($userID);
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
                $temp->notifications = null;
                $temp->save();
                $this->line(json_encode(['success'=>true, 'status' => null]));
                return null;
            }
        }
        if (is_null(Order::where('id', $request->input('orderID')))) {
            $this->line(json_encode(value: ['success'=>false, 'status' => "No Order"]));
            return;
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
                    // $this->line(json_encode(value: ['success'=>false]));=
                    $OC->returnJson('false', 'null');
                } else {
                    $userOrDriver->save();
                    $OC->delete($request);

                    $currentIndex++;
                    $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                    $userOrDriver->save();
                }
                // $this->line(json_encode(['success'=>true, 'status' => $userOrDriver->notifications]));
                return $OC->returnJson('true', $userOrDriver->notifications);
                // return;
            }
            if($currentIndex == 1) {
                // $this->line(json_encode(['success'=>false]));
                return $OC->returnJson('false', 'null');
            }
            else {
                $currentIndex++;
                $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                $userOrDriver->save();
            }
            // $this->line(json_encode(['success'=>true, 'status' => $userOrDriver->notifications]));
            return $OC->returnJson('true', $userOrDriver->notifications);
        }
        else {
            if(!(Auth::user()->isDriver) && Auth::user()->notifcations!="pending") {
                // $this->line(json_encode(['success'=>false]));
                return (new OrderController)->returnJson('true', $userOrDriver->notifications);
                return;
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

                    // $this->line(json_encode(['success'=>true, 'status' => "accepted"]));
                    return $OC->returnJson('true', $userOrDriver->notifications);
                    }
                    // Set the new notification status
                    $currentIndex++;
                    $user->notifications = $notifications[$currentIndex]; // Move to the next status
                    $user->save();

                }
            } else {
                echo ('No authenticated user found.');
            }
        }
    }
}
