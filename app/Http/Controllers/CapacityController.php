<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capacity;

class CapacityController extends Controller
{
    public function index()
    {
        $capacities = Capacity::all();
        return view('admin.capacities.index', compact('capacities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $capacity = Capacity::create($request->all());

        if ($capacity) {
            $capacities = Capacity::all();
            $view = view('admin.capacities.table', compact('capacities'))->render();
            return response()->json(['message' => 'Capacity created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create capacity'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $capacity = Capacity::findOrFail($id);
            return response()->json(['capacity' => $capacity], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch capacity details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Capacity $capacity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $capacity->update($request->all());

            if ($capacity->wasChanged()) {
                $capacities = Capacity::all();
                $table_html = view('admin.capacities.table', compact('capacities'))->render();
                return response()->json(['message' => 'Capacity updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the capacity'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update capacity: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Capacity $capacity)
    {
        try {
            $capacity->delete();
            $capacities = Capacity::all();
            $view = view('admin.capacities.table', compact('capacities'))->render();
            return response()->json(['message' => 'Capacity deleted successfully', 'capacities' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete capacity: ' . $e->getMessage()], 500);
        }
    }
}
