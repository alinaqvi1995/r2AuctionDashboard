<?php

namespace App\Http\Controllers;

use App\Models\Connectivity;
use App\Models\ModelName;
use Illuminate\Http\Request;

class ConnectivityController extends Controller
{
    public function index()
    {
        $models = ModelName::all();
        $connectivities = Connectivity::with('model')->get();
        return view('admin.connectivities.index', compact('connectivities', 'models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model_id' => 'required',
        ]);

        $connectivity = Connectivity::create($request->all());

        if ($connectivity) {
            $connectivities = Connectivity::all();
            $view = view('admin.connectivities.table', compact('connectivities'))->render();
            return response()->json(['message' => 'Connectivity created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create connectivity'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $connectivity = Connectivity::findOrFail($id);
            return response()->json(['connectivity' => $connectivity], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch connectivity details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Connectivity $connectivity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        try {
            $connectivity->update($request->all());

            if ($connectivity->wasChanged()) {
                $connectivities = Connectivity::all();
                $view = view('admin.connectivities.table', compact('connectivities'))->render();
                return response()->json(['message' => 'Connectivity updated successfully', 'connectivities' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the connectivity'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update connectivity: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Connectivity $connectivity)
    {
        try {
            $connectivity->delete();
            $connectivities = Connectivity::all();
            $view = view('admin.connectivities.table', compact('connectivities'))->render();
            return response()->json(['message' => 'Connectivity deleted successfully', 'connectivities' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete connectivity: ' . $e->getMessage()], 500);
        }
    }
}
