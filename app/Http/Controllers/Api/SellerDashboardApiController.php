<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Seller;

class SellerDashboardApiController extends Controller
{
    public function dashboard($id)
    {
        $products = Product::where('user_id', $id)->where('admin_approval', 1)->get();

        $totalValueSold = $products->sum(function ($product) {
                                    return $product->buy_now_price ?? 0;
                                });

        $totalListingsSold = $products->count();

        $listingsAcceptingBids = $products->where('bidding_close_time', '>', now())
                                    ->count();

        $currentListingValue = $products->sum('minimum_bid_price');

        $totalListingsSubmitted = $products->count();

        $dashboardData = [
            'total_value_sold' => '2,400',
            'total_listings_sold' => '677',
            'listings_accepting_bids' => '312',
            'current_listing_value' => '8,254',
            'total_listings_submitted' => '921',
            // 'total_value_sold' => $totalValueSold,
            // 'total_listings_sold' => $totalListingsSold,
            // 'listings_accepting_bids' => $listingsAcceptingBids,
            // 'current_listing_value' => $currentListingValue,
            // 'total_listings_submitted' => $totalListingsSubmitted,
        ];

        return response()->json(['data' => $dashboardData], 200);
    }
}
