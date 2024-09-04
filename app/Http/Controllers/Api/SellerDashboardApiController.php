<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Bid;
use App\Models\Seller;

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
            ->whereHas('bids')
            ->with('bids', 'images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
            ->get();

        $data = [
            'bid_products' => $products,
        ];

        return response()->json(['data' => $data], 200);
    }

    // public function bid_products($id)
    // {
    //     $products = Product::where('user_id', $id)
    //         ->whereHas('bids')
    //         ->with('bids', 'images', 'storages', 'category', 'lockStatuses', 'manufacturer', 'auctionSlot')
    //         ->get();

    //     // Optionally, if you want to format the data in a specific way
    //     $data = $products->map(function ($product) {
    //         return [
    //             'product' => $product,
    //             'bids' => $product->bids->map(function ($bid) {
    //                 return [
    //                     'id' => $bid->id,
    //                     'amount' => $bid->bid_amount,
    //                     'is_above_reserve_price' => $bid->is_above_reserve_price,
    //                     'status' => $bid->status,
    //                 ];
    //             }),
    //         ];
    //     });

    //     return response()->json(['data' => $data], 200);
    // }


    public function bid_accept($id)
    {
        $bid = Bid::findOrFail($id);
        $bid->update(['status' => 1]);

        return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
    }

    public function mySales($user_id)
    {
        $products = Product::where('user_id', $user_id)->pluck('id');

        $orders = Order::with(['user', 'product'])
            ->whereIn('product_id', $products)
            ->get();

        $total_sales = $orders->sum('amount');
        $pending_sales = $orders->where('payment_status', 0)->sum('amount');
        $no_of_items_sold = $orders->count();

        return response()->json([
            'message' => 'My Sales retrieved successfully.',
            'sales' => $orders,
            'total_sales' => $total_sales,
            'pending_sales' => $pending_sales,
            'no_of_items_sold' => $no_of_items_sold,
        ]);
    }

    public function filterOrders(Request $request, $seller_id)
    {
        $seller = Seller::where('user_id', $seller_id)->firstOrFail();

        $query = Order::with(['user', 'product']);

        if ($request->filled('buyer_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('buyer_name') . '%');
            });
        }

        if ($request->filled('product_name')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('product_name') . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->filled('order_type')) {
            $query->where('order_type', $request->input('order_type'));
        }

        $query->whereHas('product', function ($q) use ($seller) {
            $q->where('user_id', $seller->user_id);
        });

        $orders = $query->get();

        return response()->json([
            'message' => 'Filtered orders retrieved successfully.',
            'orders' => $orders,
        ]);
    }

}
