<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
//trying out github push


Route::get('/products/{product}', function (Product $product) {
    return $product;
});
