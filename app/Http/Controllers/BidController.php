<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;
use App\Mail\BidAccepted;
use App\Mail\BidPlaced;
use Illuminate\Support\Facades\Mail;

class BidController extends Controller
{
    public function index()
    {
        // $products = Product::activeBidProducts()->get();
        $bids = Bid::activeBids()->with('product')->get();
        // dd($bids->toArray());

        return view('admin.bids.index', compact('bids'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'bid_amount' => 'required|numeric|min:0.01',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = User::findOrFail($request->user_id);
        $status = 0;

        DB::beginTransaction();

        try {
            if ($request->bid_amount >= $product->reserve_price) {
                $status = 1;
            }

            $bid = Bid::with('user', 'product')->create(array_merge($request->all(), ['status' => $status]));

            Mail::to($user->email)->send(new BidPlaced($user));

            Notification::create([
                'user_id' => $bid->user_id,
                'title' => 'New Bid',
                'description' => 'New bid for product "' . $bid->product->name . '" by ' . $bid->user->full_name,
                'link' => route('bids.index'),
                'is_read' => 0,
            ]);

            DB::commit();

            return response()->json(['message' => 'Bid created successfully', 'bid' => $bid], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create bid: ' . $e->getMessage()], 500);
        }
    }

    private function createOrder(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'bid_id' => 'nullable|exists:bids,id',
            'payment_method' => 'required|string|in:cheque,stripe',
            'amount' => 'required_if:payment_method,stripe|numeric|min:0.01',
            'stripe_token' => 'required_if:payment_method,stripe|string',
        ]);

        $validatedData['bid_id'] = $request->input('bid_id', 0);
        $validatedData['status'] = 0;

        if ($validatedData['payment_method'] === 'cheque') {
            $validatedData['payment_status'] = 0;
        } elseif ($validatedData['payment_method'] === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                Charge::create([
                    'amount' => $validatedData['amount'] * 100,
                    'currency' => 'usd',
                    'source' => $validatedData['stripe_token'],
                    'description' => 'Order Payment',
                ]);
                $validatedData['payment_status'] = 1;
            } catch (\Exception $e) {
                throw new \Exception('Payment failed: ' . $e->getMessage());
            }
        }

        return Order::create($validatedData);
    }

    public function cancelBids($productId)
    {
        $bids = Bid::with('user', 'product')->where('product_id', $productId)
            ->where('status', 0)
            ->get();

        if ($bids->isEmpty()) {
            return response()->json(['message' => 'No pending bids to cancel for this product.'], 404);
        }

        foreach ($bids as $bid) {
            $bid->status = 2;
            $bid->save();
        }

        Notification::create([
            'user_id' => $bid->user_id,
            'title' => 'Bid Canceled',
            'description' => 'All bids for product "' . $bid->product->name . '" has been canceled.',
            'link' => route('bids.index'),
            'is_read' => 0,
        ]);

        return response()->json(['message' => 'All pending bids have been cancelled successfully.'], 200);
    }

    // public function acceptBid($bidId)
    // {
    //     try {
    //         $bid = Bid::with('product')->findOrFail($bidId);

    //         $order = new Order;
    //         $order->user_id = $bid->user_id;
    //         $order->product_id = $bid->product->id;
    //         $order->bid_id = $bidId;
    //         $order->amount = $bid->bid_amount;
    //         $order->order_type = 'bid';
    //         $order->status = 0;
    //         $order->save();

    //         $bid->update(['status' => 1]);

    //         Mail::to($user->email)->send(new BidAccepted($user));

    //         return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function acceptBid($bidId)
    {
        try {
            $bid = Bid::with('product', 'user')->findOrFail($bidId);

            $order = new Order;
            $order->user_id = $bid->user_id;
            $order->product_id = $bid->product->id;
            $order->bid_id = $bidId;
            $order->amount = $bid->bid_amount;
            $order->order_type = 'bid';
            $order->status = 0;
            $order->save();

            $bid->update(['status' => 1]);

            $user = $bid->user;
            Mail::to($user->email)->send(new BidAccepted($user));

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Bid Accepted',
                'description' => $order->amount . ' ' . 'Bid for product "' . $bid->product->name . '" has been accepted.',
                // 'link' => route('orders.show', $order->id), // Update with the correct route
                'link' => route('bids.index'), // Update with the correct route
                'is_read' => 0,
            ]);

            return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}