<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Illuminate\Support\Str;
use App\Traits\ImageTrait;
use App\Traits\MultipleImageTrait;

class ProductService
{
    use ImageTrait, MultipleImageTrait;
    // public function createProduct(array $data)
    // {
    //     $productData = $this->prepareProductData($data);

    //     // Create the product
    //     $product = Product::create($productData);

    //     // Handle variants
    //     if (isset ($data['variant_id'])) {
    //         foreach ($data['variant_id'] as $variantId) {
    //             // Save each variant for the product with a specific value
    //             $product->variants()->attach($variantId, ['value' => 'value', 'status' => 1]);
    //         }
    //     }

    //     return $product;
    // }

    public function createProduct(array $data)
    {
        $productData = $this->prepareProductData($data);

        // Create the product
        $product = Product::create($productData);

        // Handle variants
        if (isset($data['variant_id'])) {
            foreach ($data['variant_id'] as $index => $variantId) {
                // Create product variant
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_id' => $variantId,
                    'value' => isset($data['value'][$index]) ? $data['value'][$index] : 'default_value', // Adjust this default value as needed
                    'status' => 1
                ]);

                // Upload variant images
                if (isset($data['variant_images'][$index])) {
                    // $imagePaths = $this->uploadVariantImages($data['variant_images'][$index]);
                    $additionalImagePaths = $this->uploadMultipleImages($data['variant_images'], 'variant_images');

                    foreach ($additionalImagePaths as $additionalImage) {
                        ProductVariantImage::create([
                            'product_id' => $product->id,
                            'product_variant_id' => $productVariant->id,
                            'image' => $additionalImage['original_name'],
                        ]);
                    }
                }
            }
        }

        return $product;
    }

    // public function updateProduct(Product $product, array $data)
    // {
    //     $productData = $this->prepareProductData($data);

    //     // Update product attributes
    //     $product->update($productData);

    //     // Handle variants
    //     if (isset($data['variant_id'])) {
    //         foreach ($data['variant_id'] as $variantId) {
    //             // Save each variant for the product with a specific value
    //             $product->variants()->attach($variantId, ['value' => 'value', 'status' => 1]);
    //         }
    //     }

    //     return $product;
    // }

    public function updateProduct(Product $product, array $data)
    {
        $productData = $this->prepareProductData($data);

        // Update product attributes
        $product->update($productData);

        // Handle variants
        if (isset($data['variant_id'])) {
            // Detach all existing variants
            $product->variants()->detach();

            foreach ($data['variant_id'] as $index => $variantId) {
                // Save each variant for the product with a specific value
                $product->variants()->attach($variantId, ['value' => 'value', 'status' => 1]);

                // Upload variant images
                if (isset($data['variant_images'][$index])) {
                    // $imagePaths = $this->uploadVariantImages($data['variant_images'][$index]);
                    $additionalImagePaths = $this->uploadMultipleImages($data['variant_images'], 'variant_images');

                    foreach ($additionalImagePaths as $additionalImage) {
                        ProductVariantImage::create([
                            'product_id' => $product->id,
                            'product_variant_id' => $variantId, // Use variant ID here
                            'image' => $additionalImage['original_name'],
                        ]);
                    }
                }
            }
        }

        return $product;
    }


    protected function prepareProductData(array $data)
    {
        $productData = [
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'description' => $data['description'],
            'old_price' => $data['old_price'],
            'new_price' => $data['new_price'],
            'condition' => $data['condition'] ?? null,
            'stock_condition' => $data['stock_condition'] ?? null,
            'discount' => $data['discount'] ?? null,
            'tags' => implode(',', $data['tags'] ?? []),
            'slug' => $this->generateUniqueSlug($data['title']),
            'user_id' => auth()->id(),
            'facebook' => $data['facebook'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'youtube' => $data['youtube'] ?? null,
            'twitter' => $data['twitter'] ?? null,
            'tiktok' => $data['tiktok'] ?? null,
            'pinterest' => $data['pinterest'] ?? null,
            'linkedin' => $data['linkedin'] ?? null,
        ];

        return $productData;
    }

    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $uniqueSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $counter++;
        }
        return $uniqueSlug;
    }

    protected function uploadVariantImages($images)
    {
        $imagePaths = [];

        foreach ($images as $image) {
            $path = $image->store('variant_images');
            $imagePaths[] = $path;
        }

        return $imagePaths;
    }
}
