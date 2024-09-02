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
            'order_type' => 'required|string|in:buy_now,auction',
            'payment_method' => 'nullable|string|in:cheque,stripe',
        ]);

        $validatedData['bid_id'] = $request->input('bid_id', 0);
        $validatedData['status'] = 0;

        $product = Product::findOrFail($validatedData['product_id']);

        if ($validatedData['order_type'] == 'buy_now') {
            $validatedData['amount'] = $product->buy_now_price;
        } else {
            $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
            $validatedData['amount'] = $highestBid ? $highestBid->amount : 0;
        }

        if ($validatedData['amount'] <= 0) {
            return response()->json([
                'message' => 'Invalid amount. The amount must be greater than 0.',
            ], 400);
        }

        if ($request->hasFile('payment_recipt')) {
            if (isset($validatedData['payment_recipt'])) {
                $this->deleteImage($validatedData['payment_recipt']);
            }
            $imagePath = $this->uploadImage($request->file('payment_recipt'), 'payment_recipt');
            $validatedData['payment_recipt'] = url('storage/payment_recipt/' . $imagePath);
        }

        $order = Order::create($validatedData);

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ], 201);
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
