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
use App\Events\OrderShipmentStatusUpdated;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Public routes
Route::post('/signup', [SessionController::class, 'signUp']);
Route::post('/login', [SessionController::class, 'login']);
// Route::post('/message', function(Request $request) {
//     $message = $request->input('message');
//     $sender = $request->input('sender');

//     broadcast(new OrderShipmentStatusUpdated($message, $sender))->toOthers();
//     return response()->json(['status' => 'message sent']);
// });
Route::post('/message', [OrderController::class, 'updateShipmentStatus']);



//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/additem', [CartController::class, 'addItem']);
    Route::put('/updateorder', [CartController::class, 'update']);
    Route::delete('/deleteorder', [CartController::class, 'delete']);
    Route::delete('/deletecart', [CartController::class, 'deleteCart']);
    Route::put('/itemspurchased', [CartController::class, 'itemsPurchased']);
    Route::get('/getCart', [CartController::class, 'fetch']);
    //we have to add a method that buys the products for the user, causing the "quantity" in each of the products to decrease and remove the contents
    //of the "cart" for the user, maybe save the content somewhere else for a log or for the driver bullshit
    //haydra:did it, should be good now
    //tawfek: Nice!

    Route::post('/addstore', [StoreController::class, 'create']);
    Route::put('/updatestore', [StoreController::class, 'update']);
    Route::get('/getStore', [StoreController::class, 'fetch']);

    Route::post('/addproduct', [ProductController::class, 'create']);
    Route::put('/updateproduct', [ProductController::class, 'update']);
    Route::get('/getProduct', [ProductController::class, 'fetch']);

    Route::put('/changelogo', [UserController::class, 'changeLogo']);
    Route::post('/changepassword', [UserController::class, 'changePassword']);
    Route::get('/getUser', [UserController::class, 'fetch']);
    Route::get('/getUsers', [UserController::class, 'getUsers']);

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
