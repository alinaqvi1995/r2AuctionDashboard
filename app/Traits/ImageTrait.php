<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageTrait
{
    public function uploadImage(UploadedFile $image, $folder)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs($folder, $imageName, 'public');

        return $imageName;
    }

    public function deleteImage($imagePath)
    {
        Storage::disk('public')->delete($imagePath);
    }
}
