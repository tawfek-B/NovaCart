<?php

use App\Models\Driver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class);
            //haydra: tbh i didnot understand why u need this but i added it anyway
            /*
             i want you to find a way to make it so the id resets for the orders after deleting one of them, for example if we have orders with
            id 1,2,3,4,5 after deleting order number 3 the orders should be 1,2,3,4
            also, creating new instances of Order should also be numbered correctly. What's happening is after deleting an order and having orders 1,2,3,4
            creating a new order will give it an id of 6. If you can find a solution for that, that would be great
            */
            //haydra: i think i fixed it in the order cont in delete func

            $table->foreignIdFor(User::class);//to show which user bought the order
            $table->boolean('isAccepted');//this can be used to dictate which of the orders will pop for the driver, if it has been accepted before, then we dont show it
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
