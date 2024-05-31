<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
use App\Models\AuctionSlot;
use App\Models\ProductImage;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ImageTrait;

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

    public function create()
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
        return view('admin.products.create', compact('products', 'categories', 'capacity', 'colors', 'manufacturer', 'regions', 'modelNumber', 'lockStatus', 'grade', 'carrier'));
    }

    // public function edit($id)
    // {
    //     // try {
    //     $product = Product::with(['category', 'subcategory', 'manufacturer', 'colors', 'storages', 'regions', 'modelNumbers', 'lockStatuses', 'grades', 'carriers'])->findOrFail($id);
    //     $categories = Category::all();
    //     $subcategories = Subcategory::where('category_id', $product->category_id)->get();
    //     $categories = Category::get();
    //     $capacity = Capacity::get();
    //     $colors = Color::get();
    //     $manufacturer = Manufacturer::get();
    //     $regions = Region::get();
    //     $modelNumber = ModelNumber::get();
    //     $lockStatus = LockStatus::get();
    //     $grade = Grade::get();
    //     $carrier = Carrier::get();

    //     // dd($product->toArray());
    //     return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'categories', 'capacity', 'colors', 'manufacturer', 'regions', 'modelNumber', 'lockStatus', 'grade', 'carrier'));
    //     // return response()->json(['product' => $product, 'categories' => $categories, 'subcategories' => $subcategories], 200);
    //     // } 
    //     // catch (\Exception $e) {
    //     //     return response()->json(['error' => 'Failed to fetch product details for editing: ' . $e->getMessage()], 500);
    //     // }
    // }
    public function edit($id)
    {
        $product = Product::with([
            'category',
            'subcategory',
            'manufacturer',
            'colors',
            'storages',
            'regions',
            'modelNumbers',
            'lockStatuses',
            'grades',
            'carriers'
        ])->findOrFail($id);

        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $capacity = Capacity::get();
        $colors = Color::get();
        $manufacturer = Manufacturer::get();
        $regions = Region::get();
        $modelNumber = ModelNumber::get();
        $lockStatus = LockStatus::get();
        $grade = Grade::get();
        $carrier = Carrier::get();
        $auctionSlots = AuctionSlot::get();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories',
                'subcategories',
                'capacity',
                'colors',
                'manufacturer',
                'regions',
                'modelNumber',
                'lockStatus',
                'grade',
                'carrier',
                'auctionSlots'
            )
        );
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
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048'
        ]);

        $lotNo = Str::random(6);

        // $product = Product::create($request->except(['image', 'media']));
        $product = Product::create(array_merge($request->except(['image', 'media']), ['lot_no' => $lotNo]));


        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $product->image = $imagePath;
            $product->save();
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $mediaPath
                ]);
            }
        }

        $products = Product::all();
        $table_html = view('admin.products.table', compact('products'))->render();
        return response()->json(['message' => 'Product created successfully', 'table_html' => $table_html], 200);
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
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048'
        ]);

        if (empty($product->lot_no)) {
            $lotNo = Str::random(6);
            $request->merge(['lot_no' => $lotNo]);
        }

        $product->update($request->except(['image', 'media']));

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $imagePath = $this->uploadImage($request->file('image'), 'products');
            $product->image = $imagePath;
            $product->save();
        }

        if ($request->hasFile('media')) {
            $product->images()->delete();

            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $mediaPath
                ]);
            }
        }

        $products = Product::all();
        $table_html = view('admin.products.table', compact('products'))->render();
        return response()->json(['message' => 'Product updated successfully', 'table_html' => $table_html], 200);
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
