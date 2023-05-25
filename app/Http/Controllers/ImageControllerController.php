<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images'); // Store the image in the "public/images" directory

            // Save the image path or perform any other operations you need
            // e.g., store the path in the database
            // $yourModel->image_path = $imagePath;
            // $yourModel->save();

            return response()->json(['message' => 'Image uploaded successfully']);
        }

        return response()->json(['message' => 'No image provided'], 400);
    }
}
