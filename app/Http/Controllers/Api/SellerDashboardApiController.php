<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;

class SellerDashboardApiController extends Controller
{
    public function dashboard($id)
    {
        $products = Product::where('user_id', $id)->get();

        $totalValueSold = $products->where('status', 3)->where('admin_approval', 1)->sum(function ($product) {
            return $product->buy_now_price ?? 0;
        });

        $totalListingsSold = $products->where('status', 3)->where('admin_approval', 1)->count();

        $listingsAcceptingBids = $products->where('status', 1)->where('admin_approval', 1)->where('bidding_close_time', '>', now())
            ->count();

        // $currentListingValue = $products->sum('minimum_bid_price');

        $currentListingValue = $products->where('status', 1)->where('admin_approval', 1)->sum(function ($product) {
            return is_numeric($product->minimum_bid_price) ? $product->minimum_bid_price : 0;
        });

        $totalListingsSubmitted = $products->where('status', 1)->where('admin_approval', 1)->count();

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

    public function bid_products($id)
    {
        $products = Product::where('user_id', $id)
            ->whereHas('bidProducts', 'images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot'))
            ->with('bidProducts')
            ->get();

        $data = [
            'bid_products' => $products,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function bid_accept($id)
    {
        $bid = Bid::findOrFail($id);
        $bid->update(['status' => 1]);

        return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
    }
}
