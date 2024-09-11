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
    public function bid_accept($id)
    {
        try {
            $bid = Bid::with('product')->findOrFail($id);

            $orderData = [
                'user_id' => $bid->user_id,
                'product_id' => $bid->product->id,
                'bid_id' => $id,
                'amount' => $bid->bid_amount,
                'order_type' => 'bid',
                'status' => 0,
            ];

            $order = Order::create($orderData);

            $bid->update(['status' => 1]);

            return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function mySales($user_id)
    {
        $products = Product::where('user_id', $user_id)->pluck('id');

        // $orders = Order::with(['user', 'product'])
        //     ->whereIn('product_id', $products)
        //     ->get();

        $orders = Order::with([
            'user',
            'user.buyer',
            'product' => function ($query) {
                $query->with(
                    'colors',
                    'storages',
                    'regions',
                    'modelNumbers',
                    'lockStatuses',
                    'grades',
                    'carriers',
                    'rams',
                    'sizes',
                    'modelNames',
                    'category',
                    'user',
                    'subcategory',
                    'auctionSlot',
                    'images',
                    'manufacturer',
                    'user',
                    'bids'
                )
                    ->where('admin_approval', 1)
                    ->where('status', 1);
            }
        ])
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

        if ($request->filled('search_keyword')) {
            $keyword = $request->input('search_keyword');
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('product', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->orWhere('status', 'like', '%' . $keyword . '%')
                    ->orWhere('payment_status', 'like', '%' . $keyword . '%')
                    ->orWhere('order_type', 'like', '%' . $keyword . '%');
            });
        } else {
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
