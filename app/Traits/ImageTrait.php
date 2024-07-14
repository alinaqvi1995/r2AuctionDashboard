<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageTrait
{
    public function uploadImage(UploadedFile $image, $folder)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path($folder), $imageName);

        return $imageName;
    }

    public function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
