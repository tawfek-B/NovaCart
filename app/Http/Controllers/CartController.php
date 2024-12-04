<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    //
    public function addItem(Request $request) {

        if(!is_int($request->input('product_id'))) {
            return response()->json([
                'message' => 'Product not found'
            ], 400);
        }
        Auth::login($user = User::find(2));
        //We have to change this later
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = json_decode($user->cart,true);
        if(!is_null($cart)) {
            foreach($cart as $index => $item) {
                if($item['product_id']==$request->input('product_id')) {
                    $item['quantity'] = $request->input('quantity');
                    $cart[$index]['quantity'] += $request->input('quantity');
                    $user->cart = json_encode($cart);
                    $user->save();

                    return;
                }
            }
        }//this first checks if the cart has items, then checks each element and compares its ID to the ID in the JSON file, if the ID matches in one of them, it updates it.

        //we'll have this just in case, why not?
        $newItem = [
            'product_id' => $productId,
            'quantity' => $quantity,
        ];
        $cart[] = $newItem;
        $user->cart = $cart;
        $user->save();
    }
    public function update(Request $request) {
        Auth::login($user = User::find(2));
        //We have to change this later

        $cart = json_decode($user->cart, true);
        if(!is_null($cart)) {
            foreach($cart as $index => $item) {
                if($item['product_id']==$request->input('product_id')) {
                    $item['quantity'] = $request->input('newQuantity');
                    $cart[$index]['quantity'] = $request->input('newQuantity');
                    $user->cart = json_encode($cart);
                    $user->save();

                    return;
                }
            }
        }
    }

    public function delete(Request $request) {
        Auth::login($user = User::find(2));
        //We have to change this later

        $cart = json_decode($user->cart, true);
        if(!is_null($cart)) {
            foreach($cart as $index => $item) {
                if($item['product_id']==$request->input('product_id')) {
                    unset($cart[$index]);
                    $user->cart = json_encode($cart);
                    $user->save();

                    return;
                }
            }
        }
    }

    public function deleteCart(Request $request) {
        Auth::login($user = User::find(2));
        //We have to change this later

        if(!is_null($user->cart)) {
            $user->cart = json_encode(null, true);
            $user->save();
        }
    }
}
