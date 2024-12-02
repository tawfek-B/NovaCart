<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductCOntroller;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/adduser', [UserController::class, 'create']);
Route::get('/fetch', [UserController::class, 'fetch']);
Route::put('/changelogo', [UserController::class, 'changeLogo']);

Route::post('/addstore', [StoreController::class, 'create']);

Route::post('/addproduct', [ProductController::class, 'create']);
Route::put('/buyproduct', [ProductController::class, 'update']);


Route::post('/token', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});
//this is used i think to make sure that the user exists or some shit
