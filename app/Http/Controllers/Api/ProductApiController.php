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
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\AuctionSlot;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    use ImageTrait;

    public function store(Request $request)
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
            // 'status' => 'required|integer',
            // 'admin_approval' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048',
        ]);

        $lotNo = Str::upper(Str::random(8));
        $requestData = $request->except(['image', 'media']);
        $requestData['lot_no'] = $lotNo;

        $product = Product::create($requestData);

        // Handle file uploads
        // if ($request->hasFile('image')) {
        //     $imagePath = $this->uploadImage($request->file('image'), 'products');
        //     $product->image = $imagePath;
        //     $product->save();
        // }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                $product->images()->create(['path' => url('/') . '/' . 'product_media/' . $mediaPath]);
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
            'colors',
            'storages',
            'regions',
            'modelNumbers',
            'lockStatuses',
            'grades',
            'carriers',
            'rams',
            'sizes',
            'modelNames'
        ])->get();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load([
            'colors',
            'storages',
            'regions',
            'modelNumbers',
            'lockStatuses',
            'grades',
            'carriers',
            'rams',
            'sizes',
            'modelNames',
            'category',
            'user',
            'subcategory',
            'auctionSlot',
            'images',
            'manufacturer'
        ]);
    
        return response()->json(['product' => $product], 200);
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
            // 'admin_approval' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'media.*' => 'nullable|image|max:2048',
        ]);

        if (empty($product->lot_no)) {
            $lotNo = Str::upper(Str::random(8));
            $request->merge(['lot_no' => $lotNo]);
        }

        $product->update($request->except(['image', 'media']));

        // Handle file uploads
        // if ($request->hasFile('image')) {
        //     if ($product->image) {
        //         $this->deleteImage($product->image);
        //     }
        //     $imagePath = $this->uploadImage($request->file('image'), 'products');
        //     $product->image = $imagePath;
        //     $product->save();
        // }

        if ($request->hasFile('media')) {
            $product->images()->delete();
            foreach ($request->file('media') as $media) {
                $mediaPath = $this->uploadImage($media, 'product_media');
                $product->images()->create(['path' => url('/') . '/' . 'product_media/' . $mediaPath]);
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

    public function sellerProducts($id)
    {
        $products = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')->where('user_id', $id)->where('admin_approval', 1)->get();

        if ($products) {
            return response()->json(['product' => $products], 200);
        } else {
            return response()->json(['error' => 'No products available'], 500);
        }
    }

    public function getProSubjects()
    {
        $categories = Category::get();
        $capacity = Capacity::with('brand')->get();
        $colors = Color::with('model')->get();
        $manufacturer = Manufacturer::get();
        $regions = Region::with('model')->get();
        $modelNumber = ModelNumber::with('model', 'brand')->get();
        $lockStatus = LockStatus::get();
        $grade = Grade::with('carrier')->get();
        $carrier = Carrier::get();
        $ram = Ram::get();
        $size = Size::with('model')->get();
        $modelName = ModelName::with('category', 'manufacturer')->get();
        $auction_slot = AuctionSlot::get();

        $data = [
            'categories' => $categories,
            'capacity' => $capacity,
            'colors' => $colors,
            'manufacturer' => $manufacturer,
            'regions' => $regions,
            'modelNumber' => $modelNumber,
            'lockStatus' => $lockStatus,
            'grade' => $grade,
            'carrier' => $carrier,
            'ram' => $ram,
            'size' => $size,
            'modelName' => $modelName,
            'auction_slot' => $auction_slot,
        ];

        if ($data) {
            return response()->json(['data' => $data], 200);
        } else {
            return response()->json(['error' => 'No products available'], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {
            $product->status = $request->status;
            $product->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
