<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrier;

class CarrierController extends Controller
{
    public function index()
    {
        $carriers = Carrier::all();
        return view('admin.carriers.index', compact('carriers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $carrier = Carrier::create($request->all());

        if ($carrier) {
            $carriers = Carrier::all();
            $view = view('admin.carriers.table', compact('carriers'))->render();
            return response()->json(['message' => 'Carrier created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create carrier'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $carrier = Carrier::findOrFail($id);
            return response()->json(['carrier' => $carrier], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch carrier details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Carrier $carrier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $carrier->update($request->all());

            if ($carrier->wasChanged()) {
                $carriers = Carrier::all();
                $table_html = view('admin.carriers.table', compact('carriers'))->render();
                return back()->with(['message' => 'Carrier updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the carrier'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update carrier: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Carrier $carrier)
    {
        try {
            $carrier->delete();
            $carriers = Carrier::all();
            $view = view('admin.carriers.table', compact('carriers'))->render();
            return response()->json(['message' => 'Carrier deleted successfully', 'carriers' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete carrier: ' . $e->getMessage()], 500);
        }
    }
}
