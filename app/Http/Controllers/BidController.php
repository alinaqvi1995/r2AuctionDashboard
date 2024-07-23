<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class BidController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->get();
        return view('admin.bids.index', compact('products'));
    }
}
