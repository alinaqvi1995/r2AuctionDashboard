<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;

class BuyerDashboardController extends Controller
{
    public function dashboard($id)
    {
        $featured = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
            ->where('status', 1)
            ->where('admin_approval', 1)
            ->where('featured', 1)
            ->get();

        $lost_won = '2,400';
        $total_quantity = '120';
        $total_value = '3,232';

        $bids = Bid::query();

        $highest_bid = $bids->max('bid_amount');
        $lowest_bid = $bids->min('bid_amount');
        $total_listing_bid = $bids->count();

        $total_listing_bid_value = $bids->sum('bid_amount');

        $dashboardData = [
            'featured' => $featured,
            'lost_won' => $lost_won,
            'total_quantity' => $total_quantity,
            'total_value' => $total_value,
            'highest_bid' => $highest_bid,
            'lowest_bid' => $lowest_bid,
            'total_listing_bid' => $total_listing_bid,
            'total_listing_bid_value' => $total_listing_bid_value,
        ];

        return response()->json(['data' => $dashboardData], 200);
    }

    public function buyer_bid_products($id)
    {
        $products = Product::with('bidProducts')
            ->whereHas('bidProducts', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();

        $bids = Bid::with('product')
            ->whereHas('product', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();


        $TotalBids = $bids->count();
        $TotalBiddingAmount = $bids->sum('bid_amount');
        $WinBid = 12;

        $data = [
            'bid_products' => $products,
            'total_bids' => $TotalBids,
            'Total_bidding_amount' => $TotalBiddingAmount,
            'win_bid' => $WinBid,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function wishlist_products($id)
    {
        $products = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
            ->whereHas('wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->with('wishlist')->get();

        $data = [
            'wishlist_products' => $products,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function products()
    {
        $products = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
            ->where('admin_approval', 1)
            ->where('status', 1)
            ->get();

        if ($products) {
            return response()->json(['product' => $products], 200);
        } else {
            return response()->json(['error' => 'No products available'], 500);
        }
    }
}