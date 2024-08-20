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

        $totalValueSold = $products->where('status', 3)->sum(function ($product) {
                                    return $product->buy_now_price ?? 0;
                                });

        $totalListingsSold = $products->where('status', 3)->count();

        $listingsAcceptingBids = $products->where('status', 1)->where('bidding_close_time', '>', now())
                                    ->count();

        // $currentListingValue = $products->sum('minimum_bid_price');
        
        $currentListingValue = $products->where('status', 1)->sum(function ($product) {
            return is_numeric($product->minimum_bid_price) ? $product->minimum_bid_price : 0;
        });

        $totalListingsSubmitted = $products->where('status', 1)->count();

        $currentLiveListing = $products->where('status', 1)->count();

        $dashboardData = [
            'total_value_sold' => $totalValueSold,
            'total_listings_sold' => $totalListingsSold,
            'listings_accepting_bids' => $listingsAcceptingBids,
            'current_listing_value' => $currentListingValue,
            'total_listings_submitted' => $totalListingsSubmitted,
            'current_live_listing' => $currentLiveListing,
        ];

        return response()->json(['data' => $dashboardData], 200);
    }
}
