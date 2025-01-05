<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Store;
use App\Models\Driver;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function showUser($id)
    {
        if (is_null(User::where('id', $id)->first())) {
            return response()->json([
                'success' => 'false'
            ]);
        }
        $path = User::where('id', $id)->first()->logo;
        $filePath = storage_path("app\\public\\$path");
        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        return response()->json([
            'success' => 'false'
        ], 404);

    }
    public function showDriver($id)
    {
        if (is_null(Driver::where('id', $id)->first())) {
            return response()->json([
                'success' => 'false'
            ]);
        }
        $path = Driver::where('id', $id)->first()->image;
        $filePath = storage_path("app\\public\\$path");
        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        return response()->json([
            'success' => 'false'
        ], 404);
    }
    //
    public function showStore($id)
    {
        if (is_null(Store::where('id', $id)->first())) {
            return response()->json([
                'success' => 'false'
            ]);
        }
        $path = Store::where('id', $id)->first()->image;
        $filePath = storage_path("app\\public\\$path");
        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        return response()->json([
            'success' => 'false'
        ], 404);
    }
    //
    public function showProduct($id)
    {
        if (is_null(Product::where('id', $id)->first())) {
            return response()->json([
                'success' => 'false'
            ]);
        }
        $path = Product::where('id', $id)->first()->image;
        $filePath = storage_path("app\\public\\$path");
        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        return response()->json([
            'success' => 'false'
        ], 404);
    }

}
