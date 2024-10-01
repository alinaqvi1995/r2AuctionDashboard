<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\ModelName;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $models = ModelName::all();
        $materials = Material::with('model')->get();
        return view('admin.materials.index', compact('materials', 'models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        $material = Material::create($request->all());

        if ($material) {
            $materials = Material::all();
            $view = view('admin.materials.table', compact('materials'))->render();
            return response()->json(['message' => 'Material created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create material'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $material = Material::findOrFail($id);
            return response()->json(['material' => $material], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch material details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        try {
            $material->update($request->all());

            if ($material->wasChanged()) {
                $materials = Material::all();
                $view = view('admin.materials.table', compact('materials'))->render();
                return response()->json(['message' => 'Material updated successfully', 'materials' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the material'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update material: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Material $material)
    {
        try {
            $material->delete();
            $materials = Material::all();
            $view = view('admin.materials.table', compact('materials'))->render();
            return response()->json(['message' => 'Material deleted successfully', 'materials' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete material: ' . $e->getMessage()], 500);
        }
    }
}
