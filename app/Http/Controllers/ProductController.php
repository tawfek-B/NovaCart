<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{

    public function fetch(Request $request, $id) {

        return response()->json([
            'success' => Product::where('id', $id)->first()?true:false,
            'product' => Product::where('id', $id)->first()
        ]);
    }

    public function fetchAllProducts() {
        return Product::all();
    }
    public function fetchStoreProducts(Request $request, $id) {
        if(is_null($store = Store::where('id', $id)->first())) {
        return response()->json([
            'success' => false
        ]);//do we have to encode this?
        }
        $products = [];
        $store = Store::where('id', $id)->first();
        foreach(Product::all() as $product) {
            if($product->store_id==$store->id) {
                $products[] = $product;
            }
        }


        return response()->json([
            'success' => Store::where('id', $id)->first()?true:false,
            'products' => $products
        ]);//do we have to encode this?
    }
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
            $quantity = $request->input('quantity'),
            $storeId = $request->input('storeID')
        ];
        if(!is_null($request->file('image'))) {
            $path = $request->file('image')->store('Products', 'public');
        }
        else {
            $path="Products/default.png";
        }


        $product = Product::factory()->create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $path,
            'quantity' => $quantity,
            'store_id' => $storeId,
        ]);
    }

    public function update(Request $request, $id){


        $validated = [
            $name = $request->input('name'),
            $price = $request->input('price'),
            $description = $request->input('description'),
            $quantity = $request->input('quantity'),
        ];


            $product = Product::where('id', $id)->first();

            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->quantity = $request->input('quantity');//i don't think we need to change the store id of a product, so......


            if(!is_null($request->file('image'))) {
                $path = $request->file('image')->store('Products', 'public');
                if($product->image!="Products/default.png")
                Storage::delete($product->image);
                $product->image = str_replace('public\\', '', $path);//this replaces what's already in the user logo for the recently stored new pic
            }
            $product->save();
    }

    public function delete(Request $request, $id) {
        $product = Product::where('id', $id)->first();
        $name = $product->name;
        $product->delete();
        $i = 1;
        foreach(Product::all() as $product) {
            $product->id = $i;
            $product->save();
            $i++;
        }
        $data = ['element' => 'store', 'id' => $id, 'name'=>$name];
        session( ['delete_info' => $data]);
        return redirect()->route('delete.confirmation');
    }
}
