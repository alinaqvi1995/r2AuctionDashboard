<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bid;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;

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
        $status = 0;

        DB::beginTransaction();

        try {
            if ($request->bid_amount >= $product->reserve_price) {
                $status = 1;
                // $order = $this->createOrder($request, $product);
            }

            $bid = Bid::create(array_merge($request->all(), ['status' => $status]));

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
        $bids = Bid::where('product_id', $productId)
            ->where('status', 0)
            ->get();

        if ($bids->isEmpty()) {
            return response()->json(['message' => 'No pending bids to cancel for this product.'], 404);
        }

        foreach ($bids as $bid) {
            $bid->status = 2;
            $bid->save();
        }

        return response()->json(['message' => 'All pending bids have been cancelled successfully.'], 200);
    }

    public function acceptBid($bidId)
    {
        try {
            $bid = Bid::with('product')->findOrFail($bidId);

            $order = new Order;
            $order->user_id = $bid->user_id;
            $order->product_id = $bid->product->id;
            $order->bid_id = $bidId;
            $order->amount = $bid->bid_amount;
            $order->order_type = 'bid';
            $order->status = 0;
            $order->save();

            $bid->update(['status' => 1]);

            return response()->json(['message' => 'Bid accepted successfully', 'bid_products' => $bid], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}