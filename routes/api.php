<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Public routes
Route::post('/signup', [SessionController::class, 'signUp']);
Route::post('/login', [SessionController::class, 'login']);






//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/additem', [CartController::class, 'addItem']);
    Route::put('/updateorder', [CartController::class, 'update']);
    Route::delete('/deletefcart', [CartController::class, 'delete']);
    Route::delete('/deletecart', [CartController::class, 'deleteCart']);
    Route::put('/itemspurchased', [CartController::class, 'itemsPurchased']);
    Route::get('/getcart', [CartController::class, 'fetch']);
    //we have to add a method that buys the products for the user, causing the "quantity" in each of the products to decrease and remove the contents
    //of the "cart" for the user, maybe save the content somewhere else for a log or for the driver bullshit
    //haydra:did it, should be good now
    //tawfek: Nice!

    Route::post('/addstore', [StoreController::class, 'create']);
    Route::put('/updatestore', [StoreController::class, 'update']);
    Route::get('/getstore', [StoreController::class, 'fetch']);

    Route::post('/addproduct', [ProductController::class, 'create']);
    Route::put('/updateproduct', [ProductController::class, 'update']);
    Route::get('/getproduct', [ProductController::class, 'fetch']);

    Route::put('/changelogo', [UserController::class, 'changeLogo']);
    Route::post('/changepassword', [UserController::class, 'changePassword']);
    Route::get('/getuser', [UserController::class, 'fetch']);
    Route::get('/getusers', [UserController::class, 'getUsers']);
    Route::get('/getfavs', [UserController::class, 'getfavs']);
    Route::post('/addfavs', [UserController::class, 'addfavs']);


    Route::get('/getorder', [OrderController::class, 'fetch']);
    Route::get('/getallorders', [OrderController::class, 'fetchAll']);
    Route::delete('/deleteorder', [OrderController::class, 'delete']);


    //i just want you to add these functions, one that returns the order(the whole model, not just the 'content' variable), another functions that returns ALL of the orders haydra: bro dats like 2 lines of code gimme somethin harder (like ur pepe maybe UwU)
    //one that turns isAccepted true only when a user that is isDriver accepts the delivery (maybe add a driver_id variable to the Order model?) haydra : plz put this in the ordercont cuz my dumbass thoguth i should add an api route for it
    //haydra: i think i did it but i dont rly think its goin to work, gotta discuss dis shit with u



    Route::post('/notif', function () {//this is supposed to cycle through [pending, accepted, delivering, delivered] every 15 seconds for when the driver accepts a delivery, but whenever i call this on postman, it only changes state once, maybe give it a shot
        Artisan::call('app:update-notifications', ['userID' => Auth::id()]);
    });

    // Route::get('/gettt', function () {
    //     return response()->json(["user" => auth()->user()]);
    // });

    //haydra: for some reason its tellin me there is no auth users althought i am authed and i can do other shit that requirse a token  can u plz use the url above this /gettt to check if its returning null or anuthin else
    //tawfek: because you had the method OUTSIDE THE FUCKING PROTECTED ROUTES GROUP!

    Route::post('/logout', [SessionController::class, 'logout']);
});


Route::post('/token', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});
//this is used i think to make sure that the user exists or some shit

//I just realized that some function like delete, add and update for products and stores should be in web.php not here. We'll worry about that later though
