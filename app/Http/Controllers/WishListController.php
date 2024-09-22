<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WishList;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;

class WishListController extends Controller
{
    public function index()
    {
        $wishlist = WishList::all();
        return view('admin.sizes.wishlists', compact('wishlist'));
    }

    public function store(Request $request)
    {
        $wishlist = WishList::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

        $product = Product::with('category', 'user')->find($request->product_id);

        $user = User::find($request->user_id);

        if ($wishlist) {
            $wishlist->delete();

            Notification::create([
                'user_id' => $request->user_id,
                'title' => 'Product Removed from Wishlist',
                'description' => 'The product has been removed from wishlist' . $user->full_name,
                'link' => route('products.index'),
                'is_read' => 0,
            ]);

            return response()->json(['message' => 'Product removed from wishlist'], 201);
        } else {
            $newWishlist = new WishList;
            $newWishlist->user_id = $request->user_id;
            $newWishlist->product_id = $request->product_id;
            $newWishlist->save();

            Notification::create([
                'user_id' => $request->user_id,
                'title' => 'Product Added to Wishlist',
                'description' => 'The product has been added to wishlist' . $user->full_name,
                'link' => route('products.index'),
                'is_read' => 0,
            ]);

            return response()->json(['message' => 'Product added to wishlist'], 201);
        }
    }

}
