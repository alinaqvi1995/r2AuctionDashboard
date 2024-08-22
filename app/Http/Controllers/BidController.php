<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;

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
            // 'status' => 'required',
        ]);

        $bid = Bid::create($request->all());

        if ($bid) {
            return response()->json(['message' => 'Bid created successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to create bid'], 500);
        }
    }
}
