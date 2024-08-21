<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WishList;

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

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['message' => 'Product removed from wishlist'], 201);
        } else {
            $newWishlist = new WishList;
            $newWishlist->user_id = $request->user_id;
            $newWishlist->product_id = $request->product_id;
            $newWishlist->save();

            return response()->json(['message' => 'Product added to wishlist'], 201);
        }
    }

}
