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
use App\Models\Ram;
use App\Models\Size;
use App\Models\ModelName;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::with('user')->get();
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
        $rams = Ram::get();
        $sizes = Size::get();
        $modelNames = ModelName::get();
        $auctionSlots = AuctionSlot::get();
        return view('admin.products.create', compact('products', 'categories', 'capacity', 'colors', 'manufacturer', 'regions', 'modelNumber', 'lockStatus', 'grade', 'carrier', 'rams', 'sizes', 'modelNames', 'auctionSlots'));
    }

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
        // dd($request->toArray());
        $request['admin_approval'] = 0;
        $request['user_id'] = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable',
            'listing_type' => 'nullable',
            'material' => 'nullable',
            'generation' => 'nullable',
            'connectivity' => 'nullable',
            'quantity' => 'nullable',
            'auction_name' => 'nullable',
            'lot_address' => 'nullable',
            'lot_city' => 'nullable',
            'lot_state' => 'nullable',
            'lot_zip' => 'nullable',
            'lot_country' => 'nullable',
            'international_buyers' => 'nullable',
            'shipping_requirements' => 'nullable',
            'certificate_data_erasure' => 'nullable',
            'certificate_hardware_destruction' => 'nullable',
            'lot_sold_as_is' => 'nullable',
            'notes' => 'nullable',
            'payment_requirement' => 'nullable',
            'bidding_close_time' => 'nullable',
            'processing_time' => 'nullable',
            'minimum_bid_price' => 'nullable',
            'buy_now' => 'nullable',
            'buy_now_price' => 'nullable',
            'reserve_price' => 'nullable',
            'model_size' => 'nullable',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            // 'subcategory_id' => 'required|exists:subcategories,id',
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
            // 'status' => 'required|integer',
            // 'admin_approval' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048',
        ]);

        $lotNo = Str::upper(Str::random(8));
        do {
            $lotNo = strtoupper(Str::random(8));
        } while (Product::where('lot_no', $lotNo)->exists());

        $productData = $request->except(['image', 'media']);
        $productData['lot_no'] = $lotNo;
        $productData['certificate_hardware_destruction'] = $request->has('certificate_hardware_destruction') ? 1 : 0;
        $productData['buy_now'] = $request->has('buy_now') ? 1 : 0;

        $product = Product::create($productData);

        // if ($request->hasFile('image')) {
        //     $imagePath = $this->uploadImage($request->file('image'), 'products');
        //     $product->image = url('/') . '/' . 'products/' . $imagePath;
        //     $product->save();
        // }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => url('/') . '/' . 'product_media/' . $mediaPath
                ]);
            }
        }

        // Syncing relationships
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

        $products = Product::all();
        $table_html = view('admin.products.table', compact('products'))->render();
        return response()->json(['message' => 'Product created successfully', 'table_html' => $table_html], 200);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable',
            'listing_type' => 'nullable',
            'material' => 'nullable',
            'generation' => 'nullable',
            'connectivity' => 'nullable',
            'quantity' => 'nullable',
            'auction_name' => 'nullable',
            'lot_address' => 'nullable',
            'lot_city' => 'nullable',
            'lot_state' => 'nullable',
            'lot_zip' => 'nullable',
            'lot_country' => 'nullable',
            'international_buyers' => 'nullable',
            'shipping_requirements' => 'nullable',
            'certificate_data_erasure' => 'nullable',
            'certificate_hardware_destruction' => 'nullable',
            'lot_sold_as_is' => 'nullable',
            'notes' => 'nullable',
            'payment_requirement' => 'nullable',
            'bidding_close_time' => 'nullable',
            'processing_time' => 'nullable',
            'minimum_bid_price' => 'nullable',
            'buy_now' => 'nullable',
            'buy_now_price' => 'nullable',
            'reserve_price' => 'nullable',
            'model_size' => 'nullable',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            // 'subcategory_id' => 'required|exists:subcategories,id',
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
            do {
                $lotNo = strtoupper(Str::random(8));
            } while (Product::where('lot_no', $lotNo)->exists());
            $request->merge(['lot_no' => $lotNo]);
        }

        $product->update($request->except(['image', 'media']));

        // if ($request->hasFile('image')) {
        //     $this->deleteImage($product->image);
        //     $imagePath = $this->uploadImage($request->file('image'), 'products');
        //     $product->image = $imagePath;
        //     $product->save();
        // }

        if ($request->hasFile('media')) {
            $product->images()->delete();

            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => url('/') . '/' . 'product_media/' . $mediaPath
                ]);
            }
        }

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
            return back()->with('message', 'Product deleted successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }

    public function getManufacturersRelations($id)
    {
        try {
            $id = intval($id);

            $capacities = Capacity::where('brand_id', $id)->get();
            $models = ModelNumber::where('brand_id', $id)->get();

            return response()->json([
                'success' => true,
                'capacities' => $capacities,
                'models' => $models,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch manufacturer relations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getModelRelations($id)
    {
        try {
            $id = intval($id);

            $colors = Color::where('model_id', $id)->get();

            return response()->json([
                'success' => true,
                'colors' => $colors,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch model relations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
