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
        $driver = User::find($userID);
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
                return null;
            }
        }
        if (is_null(Order::where('id', $request->input('orderID')))) {
            return;
        }
        if ($driver->isDriver == 0) {
            echo (' \'success\': \'false\'');
        } else {
            if ($driver) {
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
                    if (is_null($DriverController->makeDelivery($request, $driver))) {
                        echo (' \'success\': \'true\'
                    status: accepted');
                    }
                } else if ($currentIndex == 3) {
                    // echo(' has been delivered');
                    $DriverController = new DriverController();
                    if (is_null($DriverController->finishedDelivery($request))) {
                        echo (' \'success\': \'false\'');
                    } else {
                        $user->save();
                        $OC->delete($request);
                    }


                    // echo(' \'success\': \'false\'');
                    //for some reason, using return with this results in "Object of class Illuminate\Http\JsonResponse could not be converted to int" error
                    return;
                }
                // Set the new notification status
                $currentIndex++;
                $user->notifications = $notifications[$currentIndex]; // Move to the next status
                $user->save();

                $this->info('User notifications updated to ' . $user->notifications);
            } else {
                echo ('No authenticated user found.');
            }
        }
    }
}
