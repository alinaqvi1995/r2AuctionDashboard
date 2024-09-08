<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ClientsFeedback;
use App\Models\News;
use App\Http\Resources\ProductResource;

class HomeController extends Controller
{
    public function homePage()
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
        ])->whereHas('auctionSlot', function ($query) {
            $query->where('auction_date', '<=', now())
                ->where('auction_date_end', '>=', now());
        })->get();

        $feedback = ClientsFeedback::where('status', 1)->get();
        $news = News::where('status', 1)->get();

        return response()->json([
            'products' => $products,
            'feedback' => $feedback,
            'news' => $news,
        ]);
    }
}
