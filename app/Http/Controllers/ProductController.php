<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Variant;
use App\Models\ProductVariantImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $categories = Category::where('type', 'ecommerce')->get();
        $variants = Variant::all();
        $products = Product::all();
        return view('dashboard.admin.products.index', compact('products', 'variants', 'categories'));
    }

    // public function create()
    // {
    //     $categories = Category::all();
    //     return view('dashboard.admin.products.create', compact('categories'));
    // }

    // public function store(Request $request)
    // {
    //     // dd($request->toArray());
    //     $request->validate([
    //         'title' => 'required',
    //         'category_id' => 'required',
    //         'description' => 'required',
    //         'old_price' => 'required',
    //         'new_price' => 'required',
    //         'status' => 'required',
    //         'variant_id' => 'required|array',
    //         'variant_id.*' => 'exists:variants,id',
    //     ]);

    //     $product = $this->productService->createProduct($request->all());

    //     if ($product) {
    //         $products = Product::all();
    //         $view = view('dashboard.admin.products.table', compact('products'))->render();

    //         return response()->json(['message' => 'Product created successfully', 'table_html' => $view], 200);
    //     } else {
    //         return response()->json(['error' => 'Failed to create Product'], 500);
    //     }
    // }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'old_price' => 'required',
            'new_price' => 'required',
            'status' => 'required',
            'variant_id' => 'required|array',
            'variant_id.*' => 'exists:variants,id',
        ]);

        $data = $request->all();

        // Check if variant_images are present in the request
        if ($request->hasFile('variant_images')) {
            $data['variant_images'] = $request->file('variant_images');
        } else {
            // If no variant images are uploaded, set an empty array
            $data['variant_images'] = [];
        }

        $product = $this->productService->createProduct($data);

        if ($product) {
            $products = Product::all();
            $view = view('dashboard.admin.products.table', compact('products'))->render();

            return response()->json(['message' => 'Product created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create Product'], 500);
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('category', 'variants', 'subcategory')->findOrFail($id);
        $categories = Category::all();
        return response()->json(['product' => $product]);
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'category_id' => 'required',
    //         'description' => 'required',
    //         'old_price' => 'required',
    //         'new_price' => 'required',
    //         'status' => 'required',
    //         'variant_id' => 'required|array',
    //         'variant_id.*' => 'exists:variants,id',
    //     ]);

    //     $product = Product::findOrFail($id);

    //     // Update product attributes
    //     $this->productService->updateProduct($product, $request->all());

    //     if ($product) {
    //         $products = Product::all();
    //         $view = view('dashboard.admin.products.table', compact('products'))->render();

    //         return response()->json(['message' => 'Product updated successfully', 'table_html' => $view], 200);
    //     } else {
    //         return response()->json(['error' => 'Failed to create Product'], 500);
    //     }

    //     // return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    // }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'old_price' => 'required',
            'new_price' => 'required',
            'status' => 'required',
            'variant_id' => 'required|array',
            'variant_id.*' => 'exists:variants,id',
        ]);

        $product = Product::findOrFail($id);

        // Prepare data for update
        $data = $request->all();

        // Check if variant_images are present in the request
        if ($request->hasFile('variant_images')) {
            $data['variant_images'] = $request->file('variant_images');
        } else {
            // If no variant images are uploaded, set an empty array
            $data['variant_images'] = [];
        }

        // Update product attributes and handle variants
        $updatedProduct = $this->productService->updateProduct($product, $data);

        if ($updatedProduct) {
            $products = Product::all();
            $view = view('dashboard.admin.products.table', compact('products'))->render();

            return response()->json(['message' => 'Product updated successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to update Product'], 500);
        }

        // return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function getsubCategories($categoryId)
    {
        // Fetch subcategories based on the provided package ID
        $data['subcategories'] = Subcategory::where('category_id', $categoryId)->get();
        $data['varients'] = Variant::where('category_id', $categoryId)->get();
        // Return subcategories as JSON response
        return response()->json($data);
    }
}
