<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/token', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json(['token' => $token], 200);
});
//this is used i think to make sure that the user exists or some shit

Route::post('/adduser', [UserController::class, 'store']);
Route::get('/fetch', [UserController::class, 'fetch']);
