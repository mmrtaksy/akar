<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    //


    public function getResizedImage($path, $width, $height)
    {
        $filePath = public_path("uploads/" . $path); // Resmin orijinal yolu


        if (!file_exists($filePath)) {
            abort(404, 'Resim bulunamadı.');
        }


        // Resmi yeniden boyutlandır
        $image = Image::make($filePath)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio(); // Oranları koru
            $constraint->upsize(); // Resmi büyütme
        });

        // Dinamik olarak cacheleme (isteğe bağlı)
        $resizedPath = "resized/{$width}x{$height}/" . basename($filePath);
        Storage::disk('public')->put($resizedPath, (string) $image->encode());

        // Resmi tarayıcıya gönder
        return response()->file(public_path("uploads/" . $resizedPath));
    }


}
