<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait MultipleImageTrait
{
    public function uploadMultipleImages(array $images, $folder)
    {
        $uploadedImages = [];

        foreach ($images as $image) {
            $originalName = $image->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $imagePath = $image->storeAs($folder, $imageName, 'public');
            $uploadedImages[] = [
                'path' => $imagePath,
                'original_name' => $originalName,
            ];
        }
        return $uploadedImages;
    }

    public function deleteMultipleImages(array $imagePaths)
    {
        foreach ($imagePaths as $image) {
            Storage::disk('public')->delete($image['path']);
        }
    }
}
