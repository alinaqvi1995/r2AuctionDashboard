<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;
use App\Services\EventService;

class SubVendorController extends Controller
{

    protected $productService, $eventService;

    public function __construct(ProductService $productService, EventService $eventService)
    {
        $this->productService = $productService;
        $this->eventService = $eventService;
    }
    
    public function index()
    {
        return view('dashboard.subVendor.pages.user_management.index');
    }

    public function indexProducts()
    {
        $categories = Category::all();
        $variants = Variant::all();
        $products = Product::where('user_id', Auth::id())->get();
        return view('dashboard.subVendor.products.index', compact('products', 'variants', 'categories'));
    }
    public function storeProducts(Request $request)
    {
        // dd($request->toArray());
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

        $product = $this->productService->createProduct($request->all());

        if ($product) {
            $products = Product::where('user_id', Auth::id())->get();
            $view = view('dashboard.admin.products.table', compact('products'))->render();

            return response()->json(['message' => 'Product created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create Product'], 500);
        }
    }
    public function editProducts($id)
    {
        $product = Product::with('category', 'variants')->findOrFail($id);
        $categories = Category::all();
        return response()->json(['product' => $product]);
    }

    public function updateProducts(Request $request, $id)
    {
        dd($request->toArray());
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
        $this->productService->updateProduct($product, $request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function indexEvents()
    {
        $packages = Package::all();
        $ticktes = Ticket::all();
        $packageId = Auth::user()->subVendor->vendor->package->id;
        $categories = Category::with('package')->get();
        $events = Event::where('user_id', Auth::id())->get(['id', 'name', 'start_date', 'end_date']);
        return view('dashboard.subVendor.events.index', compact('packages', 'categories', 'events', 'ticktes'));
    }

    public function storeEvents(Request $request)
    {
        // dd($request->package_id);
        $request->validate([
            'name' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'category_id' => 'required|exists:categories,id',
            'total_no_of_tickets' => 'required|integer|min:1',
            'venue' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'dress_code' => 'nullable|array',
            'dress_code.*' => 'nullable|string|max:255',
            'ticket_id' => 'required|array',
            'ticket_id.*' => 'exists:tickets,id',
            'description' => 'nullable|string',
            'eventType' => 'required|in:private,public',
            'start_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'end_time' => 'nullable|after:start_time',
            'all_day' => 'nullable',
            'status' => 'required|in:active,inactive',
            // 'promotional_Video' => 'nullable|file|mimes:mp4,mov,avi',
            // 'banner' => 'nullable|image|max:2048',
            // 'additional_images.*' => 'nullable|image|max:2048',
        ]);

        $request['user_id'] = Auth::id();

        if ($request->has('all_day')) {
            $request['all_day'] = $request->all_day ? 1 : 0;

            $event = $this->eventService->createEvent($request->all());

            return response()->json(['success' => 'Event created successfully.', 'event' => $event]);
        }
    }

    public function editEvents(Event $event)
    {
        $packages = Package::all();
        $categories = Category::all();
        return view('dashboard.admin.events.edit', compact('event', 'packages', 'categories'));
    }

    // Update the specified event in the database.
    public function updateEvents(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive', // Adjust options as needed
            // Add validation rules for other fields here
        ]);

        // $event->update($request->all());
        $event = $this->eventService->updateEvent($event, $request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }
}
