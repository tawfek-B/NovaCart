<?php

namespace App\Console\Commands;

use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if ($user) {
            $OC = new OrderController();
            echo ('loop');
            // Array of notification statuses in the desired order
            $notifications = ['pending', 'accepted', 'delivering', 'delivered'];

            // Logic to cycle through the notifications
            // Get the current notification and find its index
            $currentNotification = $user->notifications;
            $currentIndex = array_search($currentNotification, $notifications);

            if ($currentIndex == 2) {
                $OC->accept();
                $DriverController = new DriverController();
                $DriverController->makeDelivery();
            }

            if ($currentIndex == 4) {
                echo ('end');
                $user->notifications = null;
                $user->save();
                return 0;
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
