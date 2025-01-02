<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ImageController;
use App\Models\Product;

Route::get('/', function () {
    return view('auth/register');
});

Route::post('/reg',[SessionController::class,'adminlogin']);

Route::get('/toobad', function () {
    return view('toobad');
});

// Route::get('/welcome', function () {
//     return view('welcome');
// }); 
//haydra : changed this to a comment so u cant acsess the welcome page without logging in

Route::get('/stores', function() {
    return view('stores');
});

Route::get('/products', function() {
    return view('products');
});
// Route::get('/image/{path}', [ImageController::class, 'show'])->where('path', '.*');

Route::get('/image/{path}', [ImageController::class, 'show'])->where('path', '.*');

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

