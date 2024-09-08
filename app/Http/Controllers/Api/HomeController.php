<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class HomeController extends Controller
{
    public function homePage()
    {
        $products = Product::activeBidProducts()->with([
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
}
