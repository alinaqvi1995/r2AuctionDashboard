<?php

namespace App\Http\Controllers\API;
use App\Models\AuctionSlot;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuctionSlotApiController extends Controller
{
    public function index()
    {
        $auctionSlots = AuctionSlot::all();
        return response()->json($auctionSlots);
    }

    public function show($id)
    {
        $auctionSlot = AuctionSlot::findOrFail($id);
        return response()->json($auctionSlot);
    }
}
