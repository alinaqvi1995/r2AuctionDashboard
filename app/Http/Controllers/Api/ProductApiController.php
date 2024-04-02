<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'condition' => 'required|string|max:255',
        ]);

        $product = Product::create($request->all());
        $product->colors()->attach($request->input('color_id'));
        $product->storages()->attach($request->input('capacity_id'));
        $product->regions()->attach($request->input('region_id'));
        $product->modelNumbers()->attach($request->input('modelNumber_id'));
        $product->lockStatuses()->attach($request->input('lockStatus_id'));
        $product->grades()->attach($request->input('grade_id'));
        $product->carriers()->attach($request->input('carrier_id'));

        if ($product) {
            return response()->json(['message' => 'Product created successfully', 'product' => new ProductResource($product)], 201);
        } else {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'condition' => 'required|string|max:255',
        ]);

        try {
            $product->update($request->all());

            // Syncing related models
            $product->colors()->sync($request->input('color_id'));
            $product->storages()->sync($request->input('capacity_id'));
            $product->regions()->sync($request->input('region_id'));
            $product->modelNumbers()->sync($request->input('modelNumber_id'));
            $product->lockStatuses()->sync($request->input('lockStatus_id'));
            $product->grades()->sync($request->input('grade_id'));
            $product->carriers()->sync($request->input('carrier_id'));

            if ($product->wasChanged()) {
                return response()->json(['message' => 'Product updated successfully', 'product' => new ProductResource($product)], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the product'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product: ' . $e->getMessage()], 500);
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
