<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    //
    public function create(Request $request)
    {

        // $request->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'description' => 'required',
        //     'image' => 'required',
        //     'quantity' => 'required',
        //     'storeId' => 'required',
        // ]);

        //for some reason, putting 'required' on these causes postman to return a redirection to "novacart.test"

        $storeAttributes = [
            $name = $request->input('name'),
            $price = $request->input('price'),
            $description = $request->input('description'),
            $image = $request->input('image'),
            $quantity = $request->input('quantity'),
            $storeId = $request->input('storeId')
        ];

        $product = Product::factory()->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $image,
            'quantity' => $quantity,
            'store_id' => $storeId,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'quantity' => 'required|integer',
        ]);
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $product = Product::where('id', $id)->first();
        if ($product->quantity > $quantity) {
            $product->quantity = $product->quantity - $quantity;
            $product->save();
        } else {
            return response()->json(['messeage' => 'sry, we only have ' . $product->quantity . ' left']);
        }
    }
}
