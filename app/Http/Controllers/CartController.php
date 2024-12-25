<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DriverController;


class CartController extends Controller
{
    //
    public function addItem(Request $request)
    {

        if (!is_int($request->input('product_id'))) {
            return response()->json([
                'message' => 'Product not found'
            ], 400);
        }
        $user = Auth::user();
        //We have to change this later
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = json_decode($user->cart, true);
        if (!is_null($cart)) {
            foreach ($cart as $index => $item) {
                if ($item['product_id'] == $request->input('product_id')) {
                    $item['quantity'] = $request->input('quantity');
                    if($cart[$index]['quantity']+$request->input('quantity') > Product::where('id', $productId)->first()) {
                        return response()->json([
                            "success" => "false"
                        ]);//added this just in case the user orders an extra amount of a product, but they ordered more than what's available
                    }
                    $cart[$index]['quantity'] += $request->input('quantity');
                    $user->cart = json_encode($cart);
                    $user->save();

                    return response()->json([
                        "success" => "true"
                    ]);
                }
            }
        }//haydra: we dont need to check if we have enough of the item right da boys at front end are goin to do it ?
        //this first checks if the cart has items, then checks each element and compares its ID to the ID in the JSON file, if the ID matches in one of them, it updates it.

        //we'll have this just in case, why not?
        $newItem = [
            'product_id' => $productId,
            'quantity' => $quantity,
        ];
        $cart[] = $newItem;
        $user->cart = $cart;
        $user->save();
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        //We have to change this later

        $cart = json_decode($user->cart, true);
        if (!is_null($cart)) {
            foreach ($cart as $index => $item) {
                if ($item['product_id'] == $request->input('product_id')) {
                    $item['quantity'] = $request->input('newQuantity');
                    $cart[$index]['quantity'] = $request->input('newQuantity');
                    $user->cart = json_encode($cart);
                    $user->save();

                    return;
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        //We have to change this later

        $cart = json_decode($user->cart, true);
        if (!is_null($cart)) {
            foreach ($cart as $index => $item) {
                if ($item['product_id'] == $request->input('product_id')) {
                    unset($cart[$index]);
                    $user->cart = json_encode($cart);
                    $user->save();

                    return;
                }
            }
        }
    }

    public function deleteCart(Request $request)
    {
        $user = Auth::user();
        //We have to change this later

        if (!is_null($user->cart)) {
            $user->cart = json_encode(null, true);
            $user->save();
        }
    }

    public function itemsPurchased(Request $request)
    {
        $user = Auth::user();
        $prod = 0;
        $cart = json_decode($user->cart, true);
        if (!is_null($cart)) {
            foreach ($cart as $index) {
                $counter = 0;
                foreach ($index as $key => $value) {
                    if ($counter != 1) {
                        $prod = $value;
                    } else {
                        $dbProd = Product::where('id', operator: $prod)->first();
                        $dbProd->quantity -= $value;
                        $dbProd->save();
                    }
                    $counter++;
                }

            }
            $order = Order::create([
                'content' => json_encode($cart),
                'user_id' => $user->id,
                'isAccepted' => 0,
            ]);
            $order->save();
            $user->cart = json_encode(null, true);
            $user->save();

            // foreach ($cart as $product) {
            //     echo $product['product_id'] . "\n"; // Print each product_id
            //     $firstProduct = $cart[0];
            //     echo $firstProduct['product_id']; // This will print 3

            // }

            return response()->json(['msg' => 'worked'], 200);

        }

    }
    public function fetch()
    {
        $user = Auth::user();
        return $user->cart;
    }
}
