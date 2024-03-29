<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('admin.regions.index', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $region = Region::create($request->all());

        if ($region) {
            $regions = Region::all();
            $view = view('admin.regions.table', compact('regions'))->render();
            return response()->json(['message' => 'Region created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create region'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $region = Region::findOrFail($id);
            return response()->json(['region' => $region], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch region details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $region->update($request->all());

            if ($region->wasChanged()) {
                $regions = Region::all();
                $table_html = view('admin.regions.table', compact('regions'))->render();
                return response()->json(['message' => 'Region updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the region'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update region: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Region $region)
    {
        try {
            $region->delete();
            $regions = Region::all();
            $view = view('admin.regions.table', compact('regions'))->render();
            return response()->json(['message' => 'Region deleted successfully', 'regions' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete region: ' . $e->getMessage()], 500);
        }
    }
}