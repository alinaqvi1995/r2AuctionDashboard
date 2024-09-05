<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;
use App\Models\Order;

class BuyerDashboardController extends Controller
{
    public function dashboard($id)
    {
        $featured = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot', 'bids', 'bids.user')
            ->where('status', 1)
            ->where('admin_approval', 1)
            ->where('featured', 1)
            ->get();

        $bids = Bid::query();

        $lost_won = $bids->clone()->where('user_id', $id)->where('status', 1)->sum('bid_amount');
        $total_quantity = $bids->clone()->where('user_id', $id)->count();
        $total_value = $bids->clone()->where('user_id', $id)->sum('bid_amount');

        $highest_bid = $bids->clone()->where('user_id', $id)->max('bid_amount');
        $lowest_bid = $bids->clone()->where('user_id', $id)->min('bid_amount');
        $total_listing_bid = $bids->clone()->where('user_id', $id)->count();

        $total_listing_bid_value = $bids->clone()->where('user_id', $id)->sum('bid_amount');

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
        $products = Product::with('bids', 'images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
            ->whereHas('bids', function ($query) use ($id) {
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
            'total_bidding_amount' => $TotalBiddingAmount,
            'win_bid' => $WinBid,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function wishlist_products($id)
    {
        $products = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot', 'bids')
            ->whereHas('wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })->with('wishlist')->get();

        $data = [
            'wishlist_products' => $products,
        ];

        return response()->json(['data' => $data], 200);
    }

    public function buyer_dashboard_products()
    {
        $products = Product::with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot', 'bids', 'bids.user')
            ->where('admin_approval', 1)
            ->where('status', 1)
            ->get();

        if ($products) {
            return response()->json(['product' => $products], 200);
        } else {
            return response()->json(['error' => 'No products available'], 500);
        }
    }

    public function myOrders($user_id)
    {
        $orders = Order::with([
            'product' => function ($query) {
                $query->with('images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot', 'bids', 'bids.user')
                    ->where('admin_approval', 1)
                    ->where('status', 1);
            }
        ])->where('user_id', $user_id)->get();

        $orders_awaiting_payment = $orders->where('payment_status', 0)->count();
        $total_due = $orders->where('payment_status', 0)->sum('amount');
        $oldest_order = $orders->sortBy('created_at')->first();

        return response()->json([
            'message' => 'My Orders retrieved successfully.',
            // 'orders_awaiting_payment' => $orders_awaiting_payment,
            // 'total_due' => $total_due,
            // 'oldest_order' => $oldest_order,
            'orders_awaiting_payment' => $orders_awaiting_payment,
            'total_due' => $total_due,
            'oldest_order' => $oldest_order,
            'orders' => $orders,
        ]);
    }
}