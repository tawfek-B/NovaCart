<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //
    public function show($path) {
        $filePath = storage_path("app\\public\\$path");
        if(file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
        return response()->json([
            'error' => 'File not found'
        ], 404);
    }

}
