<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ram;
use App\Models\ModelName;

class RamController extends Controller
{
    public function index()
    {
        $rams = Ram::all();
        $models = ModelName::all();
        return view('admin.rams.index', compact('rams', 'models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        $ram = Ram::create($request->all());

        if ($ram) {
            $rams = Ram::all();
            $view = view('admin.rams.table', compact('rams'))->render();
            return response()->json(['message' => 'Ram created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create ram'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $ram = Ram::findOrFail($id);
            return response()->json(['ram' => $ram], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch ram details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Ram $ram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        try {
            $ram->update($request->all());

            if ($ram->wasChanged()) {
                $rams = Ram::all();
                $table_html = view('admin.rams.table', compact('rams'))->render();
                return response()->json(['message' => 'Ram updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the ram'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update ram: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Ram $ram)
    {
        try {
            $ram->delete();
            $rams = Ram::all();
            $view = view('admin.rams.table', compact('rams'))->render();
            return response()->json(['message' => 'Ram deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete ram: ' . $e->getMessage()], 500);
        }
    }
}
