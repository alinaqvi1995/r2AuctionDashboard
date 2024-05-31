<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionSlot;

class AuctionSlotController extends Controller
{
    public function index()
    {
        $auctionSlots = AuctionSlot::all();
        return view('admin.auction_slots.index', compact('auctionSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'auction_date' => 'required|string|max:255',
            'auction_date_end' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $auctionSlot = AuctionSlot::create($request->all());

        if ($auctionSlot) {
            $auctionSlots = AuctionSlot::all();
            $view = view('admin.auction_slots.table', compact('auctionSlots'))->render();
            return response()->json(['message' => 'Auction slot created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create auction slot'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $auctionSlot = AuctionSlot::findOrFail($id);
            return response()->json(['auction_slot' => $auctionSlot], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch auction slot details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, AuctionSlot $auctionSlot)
    {
        $request->validate([
            'auction_date' => 'required|string|max:255',
            'auction_date_end' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $auctionSlot->update($request->all());

            if ($auctionSlot->wasChanged()) {
                $auctionSlots = AuctionSlot::all();
                $tableHtml = view('admin.auction_slots.table', compact('auctionSlots'))->render();
                return response()->json(['message' => 'Auction slot updated successfully', 'table_html' => $tableHtml], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the auction slot'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update auction slot: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(AuctionSlot $auctionSlot)
    {
        try {
            $auctionSlot->delete();
            $auctionSlots = AuctionSlot::all();
            $view = view('admin.auction_slots.table', compact('auctionSlots'))->render();
            return response()->json(['message' => 'Auction slot deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete auction slot: ' . $e->getMessage()], 500);
        }
    }
}
