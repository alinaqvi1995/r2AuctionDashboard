<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $usersCount = User::count();
        $bidsCount = Product::activeBidProducts()->count();
        $products = Product::activeBidProducts()->with('user')->get()->take(5);
        return view('admin.pages.index', compact('products', 'productsCount', 'usersCount', 'bidsCount'));
    }
}
