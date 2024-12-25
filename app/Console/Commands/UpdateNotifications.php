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
    protected $signature = 'app:update-notifications';

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
        //// Get the user (assumed to be logged in or authenticated)
        // $user = Auth::user();
        $user = User::where('id', Order::where('id', $request->input('orderID'))->first()->user_id)->first();
        // $user = Auth::user();
        if ($user) {
            $OC = new OrderController();
            echo ('loop');
            // Array of notification statuses in the desired order
            $notifications = [null, 'pending', 'accepted', 'delivering', 'delivered'];

            // Logic to cycle through the notifications
            // Get the current notification and find its index
            $currentNotification = $user->notifications;
            $currentIndex = array_search($currentNotification, $notifications);

            if ($currentIndex == 1) {
                echo(' is delivering');
                $OC->accept($request);
                $DriverController = new DriverController();
                $DriverController->makeDelivery($request);
            }

            if ($currentIndex == 4) {
                echo(' has been delivered');
                $DriverController = new DriverController();
                $DriverController->finishedDelivery($request);
                $user->notifications = null;
                $user->save();
                $OC->delete($request);

                response()->json([
                    'success' => "false",
                ]);//for some reason, using return with this results in "Object of class Illuminate\Http\JsonResponse could not be converted to int" error
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
