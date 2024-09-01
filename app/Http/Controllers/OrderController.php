<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'bid_id' => 'nullable|exists:bids,id',
            // 'payment_method' => 'required|string|in:cheque,stripe',
            // 'payment_status' => 'required|integer',
            // 'amount' => 'required_if:payment_method,stripe|numeric|min:0.01',
            // 'stripe_token' => 'required_if:payment_method,stripe|string',
        ]);

        $validatedData['bid_id'] = $request->input('bid_id', 0);
        $validatedData['status'] = 0;

        $product = Product::findOrFail($validatedData['product_id']);

        if ($request->input('order_type') && $request->input('order_type') == 'buy_now') {
            $validatedData['amount'] = $product->buy_now_price;
            $validatedData['order_type'] = 'buy_now';
        } else {
            $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
            $validatedData['amount'] = $highestBid ? $highestBid->amount : 0;
            $validatedData['order_type'] = 'auction';
        }

        // if ($validatedData['payment_method'] === 'cheque') {
        //     $validatedData['payment_status'] = 0;
        // } elseif ($validatedData['payment_method'] === 'stripe') {
        //     Stripe::setApiKey(env('STRIPE_SECRET'));

        //     try {
        //         $charge = Charge::create([
        //             'amount' => $validatedData['amount'] * 100,
        //             'currency' => 'usd',
        //             'source' => $validatedData['stripe_token'],
        //             'description' => 'Order Payment',
        //         ]);

        //         $validatedData['payment_status'] = 1;
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
        //     }
        // }

        $order = Order::create($validatedData);

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|integer',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully.',
            'order' => $order,
        ], 200);
    }
}
