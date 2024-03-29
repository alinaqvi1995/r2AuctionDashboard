<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelNumber;

class ModelNumberController extends Controller
{
    public function index()
    {
        $modelnumbers = ModelNumber::all();
        return view('admin.model_numbers.index', compact('modelnumbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $modelnumber = ModelNumber::create($request->all());

        if ($modelnumber) {
            $modelnumbers = ModelNumber::all();
            $view = view('admin.model_numbers.table', compact('modelnumbers'))->render();
            return response()->json(['message' => 'Model Number created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create Model Number'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $modelnumber = ModelNumber::findOrFail($id);
            return response()->json(['modelnumber' => $modelnumber], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch Model Number details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, ModelNumber $modelnumber)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $modelnumber->update($request->all());

            if ($modelnumber->wasChanged()) {
                $modelnumbers = ModelNumber::all();
                $table_html = view('admin.model_numbers.table', compact('modelnumbers'))->render();
                return back()->with(['message' => 'Model Number updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the Model Number'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Model Number: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(ModelNumber $modelnumber)
    {
        try {
            $modelnumber->delete();
            $modelnumbers = ModelNumber::all();
            $view = view('admin.model_numbers.table', compact('modelnumbers'))->render();
            return response()->json(['message' => 'Model Number deleted successfully', 'modelnumbers' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete Model Number: ' . $e->getMessage()], 500);
        }
    }
}
