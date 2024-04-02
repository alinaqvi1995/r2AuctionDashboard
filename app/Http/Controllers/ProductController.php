<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import the Product model
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Color;
use App\Models\Capacity;
use App\Models\Region;
use App\Models\ModelNumber;
use App\Models\LockStatus;
use App\Models\Grade;
use App\Models\Carrier;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::get();
        $capacity = Capacity::get();
        $colors = Color::get();
        $manufacturer = Manufacturer::get();
        $regions = Region::get();
        $modelNumber = ModelNumber::get();
        $lockStatus = LockStatus::get();
        $grade = Grade::get();
        $carrier = Carrier::get();
        return view('admin.products.index', compact('products', 'categories', 'capacity', 'colors', 'manufacturer', 'regions', 'modelNumber', 'lockStatus', 'grade', 'carrier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
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
            $products = Product::all();
            $view = view('admin.products.table', compact('products'))->render();
            return response()->json(['message' => 'Product created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::with(['category', 'subcategory', 'manufacturer', 'colors', 'storages', 'regions', 'modelNumbers', 'lockStatuses', 'grades', 'carriers'])->findOrFail($id);
            $categories = Category::all();
            $subcategories = Subcategory::where('category_id', $product->category_id)->get();

            return response()->json(['product' => $product, 'categories' => $categories, 'subcategories' => $subcategories], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch product details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'condition' => 'required|string|max:255',
        ]);

        try {
            $product->update($request->all());

            // Sync relationships
            $product->colors()->sync($request->input('color_id'));
            $product->storages()->sync($request->input('capacity_id'));
            $product->regions()->sync($request->input('region_id'));
            $product->modelNumbers()->sync($request->input('modelNumber_id'));
            $product->lockStatuses()->sync($request->input('lockStatus_id'));
            $product->grades()->sync($request->input('grade_id'));
            $product->carriers()->sync($request->input('carrier_id'));

            if ($product->wasChanged()) {
                $products = Product::all();
                $table_html = view('admin.products.table', compact('products'))->render();
                return response()->json(['message' => 'Product updated successfully', 'table_html' => $table_html], 200);
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
            $products = Product::all();
            $view = view('admin.products.table', compact('products'))->render();
            return response()->json(['message' => 'Product deleted successfully', 'products' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }
}
