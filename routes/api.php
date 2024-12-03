<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductCOntroller;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup', [UserController::class, 'signUp']);
Route::get('/fetch', [UserController::class, 'fetch']);
Route::put('/changelogo', [UserController::class, 'changeLogo']);
Route::middleware('auth:sanctum')->post('/changepassword', [UserController::class, 'changePassword']);

Route::post('/additem', [CartController::class, 'addItem']);
Route::put('/updateorder', [CartController::class, 'update']);
Route::delete('/deleteorder', [CartController::class, 'delete']);
Route::delete('/deletecart', [CartController::class, 'deleteCart']);

Route::post('/addstore', [StoreController::class, 'create']);//add patch for store attributes like name, location, opening and closing time

Route::post('/addproduct', [ProductController::class, 'create']);
Route::put('/updateproduct', [ProductController::class, 'update']);

Route::post('/login', [SessionController::class, 'login']);
Route::post('/logout', [SessionController::class, 'logout']);



Route::post('/token', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});
//this is used i think to make sure that the user exists or some shit
