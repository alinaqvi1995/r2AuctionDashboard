<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelName;

class ModelNameController extends Controller
{
    public function index()
    {
        $modelNames = ModelName::all();
        return view('admin.modelNames.index', compact('modelNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $modelName = ModelName::create($request->all());

        if ($modelName) {
            $modelNames = ModelName::all();
            $view = view('admin.modelNames.table', compact('modelNames'))->render();
            return response()->json(['message' => 'ModelName created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create modelName'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $modelName = ModelName::findOrFail($id);
            return response()->json(['modelName' => $modelName], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch modelName details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, ModelName $modelName)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $modelName->update($request->all());

            if ($modelName->wasChanged()) {
                $modelNames = ModelName::all();
                $table_html = view('admin.modelNames.table', compact('modelNames'))->render();
                return response()->json(['message' => 'ModelName updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the modelName'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update modelName: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(ModelName $modelName)
    {
        try {
            $modelName->delete();
            $modelNames = ModelName::all();
            $view = view('admin.modelNames.table', compact('modelNames'))->render();
            return response()->json(['message' => 'ModelName deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete modelName: ' . $e->getMessage()], 500);
        }
    }
}
