<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;

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

        $productAttributes = [
            $name = $request->input('name'),
            $price = $request->input('price'),
            $description = $request->input('description'),
            $image = $request->input('image'),
            $quantity = $request->input('quantity'),
            $storeId = $request->input('storeID')
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

    public function update(Request $request){

        $validated = [
            $name = $request->input('name'),
            $price = $request->input('price'),
            $description = $request->input('description'),
            $image = $request->input('image'),
            $quantity = $request->input('quantity'),
        ];

            $product = Product::where('id', $request->input('productID'))->first();

            $product->name = $name;
            $product->price = $price;
            $product->description = $description;
            $product->image = $image;
            $product->quantity = $quantity;//i don't think we need to change the store id of a product, so......

            $product->save();

            return response()->json([
                'message' => 'product updated successfully',
                'data' => $product,
            ], 200);
    }
    public function fetch(Request $request) {
        return Product::where('id', $request->input('productID'))->first();
    }

    public function fetchAllProducts() {
        return Product::all();
    }
    public function fetchStoreProducts(Request $request) {
        $products = [];
        $store = Store::where('id', $request->input('storeID'))->first();
        foreach(Product::all() as $product) {
            if($product->store_id==$store->id) {
                $products[] = $product;
            }
        }
        return $products;//do we have to encode this?
    }
}
