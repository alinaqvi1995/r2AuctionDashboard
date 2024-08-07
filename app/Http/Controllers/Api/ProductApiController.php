<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Capacity;
use App\Models\Region;
use App\Models\ModelNumber;
use App\Models\LockStatus;
use App\Models\Grade;
use App\Models\Carrier;
use App\Models\Ram;
use App\Models\Size;
use App\Models\ModelName;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'condition' => 'required|string|max:255',
            'auction_slot_id' => 'nullable|exists:auction_slots,id',
            'color_id' => 'nullable|array',
            'color_id.*' => 'exists:colors,id',
            'region_id' => 'nullable|array',
            'region_id.*' => 'exists:regions,id',
            'capacity_id' => 'nullable|array',
            'capacity_id.*' => 'exists:capacities,id',
            'modelNumber_id' => 'nullable|array',
            'modelNumber_id.*' => 'exists:model_numbers,id',
            'carrier_id' => 'nullable|array',
            'carrier_id.*' => 'exists:carriers,id',
            'status' => 'required|integer',
            'admin_approval' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048',
        ]);

        $lotNo = Str::random(6);
        $requestData = $request->except(['image', 'media']);
        $requestData['lot_no'] = $lotNo;

        $product = Product::create($requestData);

        // Handle file uploads
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $product->image = $imagePath;
            $product->save();
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                $product->images()->create(['path' => $mediaPath]);
            }
        }

        // Sync relationships
        $product->colors()->sync($request->input('color_id', []));
        $product->storages()->sync($request->input('capacity_id', []));
        $product->regions()->sync($request->input('region_id', []));
        $product->modelNumbers()->sync($request->input('modelNumber_id', []));
        $product->lockStatuses()->sync($request->input('lock_status_id', []));
        $product->grades()->sync($request->input('grade_id', []));
        $product->carriers()->sync($request->input('carrier_id', []));
        $product->rams()->sync($request->input('ram_id', []));
        $product->sizes()->sync($request->input('size_id', []));
        $product->modelNames()->sync($request->input('model_name_id', []));

        if ($product) {
            return response()->json(['message' => 'Product created successfully', 'product' => new ProductResource($product)], 201);
        } else {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function index()
    {
        $products = Product::with([
            'colors', 'storages', 'regions', 'modelNumbers', 
            'lockStatuses', 'grades', 'carriers', 'rams', 
            'sizes', 'modelNames'
        ])->get();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load([
            'colors', 'storages', 'regions', 'modelNumbers', 
            'lockStatuses', 'grades', 'carriers', 'rams', 
            'sizes', 'modelNames'
        ]);
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'condition' => 'required|string|max:255',
            'auction_slot_id' => 'nullable|exists:auction_slots,id',
            'color_id' => 'nullable|array',
            'color_id.*' => 'exists:colors,id',
            'region_id' => 'nullable|array',
            'region_id.*' => 'exists:regions,id',
            'capacity_id' => 'nullable|array',
            'capacity_id.*' => 'exists:capacities,id',
            'modelNumber_id' => 'nullable|array',
            'modelNumber_id.*' => 'exists:model_numbers,id',
            'carrier_id' => 'nullable|array',
            'carrier_id.*' => 'exists:carriers,id',
            'status' => 'required|integer',
            'admin_approval' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048',
        ]);

        if (empty($product->lot_no)) {
            $lotNo = Str::random(6);
            $request->merge(['lot_no' => $lotNo]);
        }

        $product->update($request->except(['image', 'media']));

        // Handle file uploads
        if ($request->hasFile('image')) {
            if ($product->image) {
                $this->deleteImage($product->image);
            }
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $product->image = $imagePath;
            $product->save();
        }

        if ($request->hasFile('media')) {
            $product->images()->delete();
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                $product->images()->create(['path' => $mediaPath]);
            }
        }

        // Sync relationships
        $product->colors()->sync($request->input('color_id', []));
        $product->storages()->sync($request->input('capacity_id', []));
        $product->regions()->sync($request->input('region_id', []));
        $product->modelNumbers()->sync($request->input('modelNumber_id', []));
        $product->lockStatuses()->sync($request->input('lock_status_id', []));
        $product->grades()->sync($request->input('grade_id', []));
        $product->carriers()->sync($request->input('carrier_id', []));
        $product->rams()->sync($request->input('ram_id', []));
        $product->sizes()->sync($request->input('size_id', []));
        $product->modelNames()->sync($request->input('model_name_id', []));

        if ($product->wasChanged()) {
            return response()->json(['message' => 'Product updated successfully', 'product' => new ProductResource($product)], 200);
        } else {
            return response()->json(['error' => 'No changes detected for the product'], 400);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }
}
