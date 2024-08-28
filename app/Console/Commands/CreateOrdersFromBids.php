<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class CreateOrdersFromBids extends Command
{
    protected $signature = 'orders:create-from-bids';
    protected $description = 'Create orders from highest bids when auction ends';

    public function handle()
    {
        $products = Product::whereHas('auctionSlot', function ($query) {
            $query->where('auction_date_end', '<=', Carbon::now()->format('Y-m-d\TH:i'));
        })->with('bids')->get();

        foreach ($products as $product) {
            if ($product->bids->isNotEmpty()) {
                $highestBid = $product->bids()->orderBy('amount', 'desc')->first();

                Order::create([
                    'user_id' => $highestBid->user_id,
                    'product_id' => $product->id,
                    'bid_id' => $highestBid->id,
                    'amount' => $highestBid->amount,
                ]);
            }
        }

        $this->info('Orders created from bids for finished auctions.');
    }
}
