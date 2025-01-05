<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ImageController;
use App\Models\Product;

//Public routes
Route::get('/', function () {
    return view('auth/register');
});

Route::post('/reg',[SessionController::class,'adminlogin']);

Route::get('/toobad', function () {
    return view('tooBad');
});

Route::get('/getuserimage/{id}', [ImageController::class, 'showUser']);
Route::get('/getdriverimage/{id}', [ImageController::class, 'showDriver']);
Route::get('/getstoreimage/{id}', [ImageController::class, 'showStore']);
Route::get('/getproductimage/{id}', [ImageController::class, 'showProduct']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

Route::get('/welcome', function () {
    return view('welcome');
});
//haydra : changed this to a comment so u cant acsess the welcome page without logging in




Route::get('/stores', function() {
    return view('stores');
});

Route::get('/addstore', function() {
    return view('storesAdd');
});

Route::post('/addstore', [StoreController::class, 'create']);

Route::get('/updatestore/{id}', function($id) {
    session(['store_id' => $id]);
    return view('storesUpdate');
});

Route::post('/updatestore/{id}', [StoreController::class, 'update']);

Route::delete('/deletestore/{id}', [StoreController::class, 'delete']);


Route::get('/products', function() {
    return view('products');
});

Route::get('/addproduct', function() {
    return view('productsAdd');
});

Route::post('/addproduct', [ProductController::class, 'create']);

Route::get('/updateproduct/{id}', function($id) {
    session(['product_id' => $id]);
    return view('productsUpdate');
});

Route::post('/updateproduct/{id}', [ProductController::class, 'update']);//Obviously we're not using these in the app, only in the website

Route::delete('/deleteproduct/{id}', [ProductController::class, 'delete']);

Route::get('/drivers', function() {
    return view('drivers');
});

Route::get('/adddriver', function() {
    return view('driversAdd');
});

Route::post('/adddriver', [DriverController::class, 'create']);

Route::get('/updatedriver/{id}', function($id) {
    session(['driver_id' => $id]);
    return view('driversUpdate');
});

Route::post('/updatedriver/{id}', [DriverController::class, 'update']);//Obviously we're not using these in the app, only in the website

Route::delete('/deletedriver/{id}', [DriverController::class, 'delete']);

Route::get('/confirmadd', function() {
    return view(view: 'confirmedAdd');
})->name('add.confirmation');

Route::get('/confirmupdate', function() {
    return view(view: 'confirmedUpdate');
})->name('update.confirmation');

Route::get('/confirmdelete', function() {
    return view(view: 'confirmedDelete');
})->name('delete.confirmation');


// Route::get('/register', [UserController::class, 'create']);
// Route::post('/register', [UserController::class, 'store']);

// Route::get('/login', [SessionController::class, 'create']);
// Route::post('/login', [SessionController::class, 'store']);

//trying out github push


Route::get('/products/{product}', function (Product $product) {
    return $product;
});

});
