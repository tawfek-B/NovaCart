<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Models\Product;

Route::get('/', function () {
    return view('auth/register');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/stores', function() {
    return view('stores');
});
Route::get('/products', function() {
    return view('products');
});
Route::post('/addstore', [StoreController::class, 'create']);
Route::put('/updatestore', [StoreController::class, 'update']);

Route::post('/addproduct', [ProductController::class, 'create']);
Route::put('/updateproduct', [ProductController::class, 'update']);//Obviously we're not using these in the app, only in the website
// Route::get('/register', [UserController::class, 'create']);
// Route::post('/register', [UserController::class, 'store']);

// Route::get('/login', [SessionController::class, 'create']);
// Route::post('/login', [SessionController::class, 'store']);

//trying out github push


Route::get('/products/{product}', function (Product $product) {
    return $product;
});

