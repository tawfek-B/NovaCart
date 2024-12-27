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
                echo (' \'success\': \'true\'
                      \'status\': \'null\'');
                return null;
            }
        }
        if (is_null(Order::where('id', $request->input('orderID')))) {
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
                    echo (' \'success\': \'false\'');
                } else {
                    $userOrDriver->save();
                    $OC->delete($request);

                    $currentIndex++;
                    $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                    $userOrDriver->save();
                }
                echo (' \'success\': \'true\'
                      \'status\': \''.$userOrDriver->notifications.'\'');
                return;
            }
            if($currentIndex == 1) {
                echo('\'success\': \'false\'');
            }
            else {
                $currentIndex++;
                $userOrDriver->notifications = $notifications[$currentIndex]; // Move to the next status
                $userOrDriver->save();
            }
            echo (' \'success\': \'true\'
                  \'status\': \''.$userOrDriver->notifications.'\'');

            $this->info('User notifications updated to ' . $userOrDriver->notifications);
        }
        else {
            if(!(Auth::user()->isDriver) && Auth::user()->notifcations!="pending") {
                echo ('\'success\': \'false\'');
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
                        echo (' \'success\': \'true\'
                    \'status\': \'accepted\'');
                    }
                    // Set the new notification status
                    $currentIndex++;
                    $user->notifications = $notifications[$currentIndex]; // Move to the next status
                    $user->save();

                    $this->info('User notifications updated to ' . $user->notifications);
                }
            } else {
                echo ('No authenticated user found.');
            }
        }
    }
}
