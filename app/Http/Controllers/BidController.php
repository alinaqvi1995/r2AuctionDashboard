<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;
use App\Models\Order;

class BidController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->get();
        return view('admin.bids.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'bid_amount' => 'required|numeric|min:0.01',
        ]);

        $product = Product::findOrFail($request->product_id);
        $status = 0;

        if ($request->bid_amount >= $product->reserve_price) {
            $status = 1;

            // $order = Order::create([
            //     'user_id' => $request->user_id,
            //     'product_id' => $product->id,
            //     'amount' => $request->bid_amount,
            // ]);
        }

        $bid = Bid::create(array_merge($request->all(), ['status' => $status]));

        if ($bid) {
            return response()->json(['message' => 'Bid created successfully', 'bid' => $bid], 201);
        } else {
            return response()->json(['error' => 'Failed to create bid'], 500);
        }
    }
}
