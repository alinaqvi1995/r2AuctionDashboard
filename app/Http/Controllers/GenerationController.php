<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use App\Models\ModelName;
use Illuminate\Http\Request;

class GenerationController extends Controller
{
    public function index()
    {
        $models = ModelName::all();
        $generations = Generation::with('model')->get();
        return view('admin.generations.index', compact('generations', 'models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model_id' => 'required',
        ]);

        $generation = Generation::create($request->all());

        if ($generation) {
            $generations = Generation::all();
            $view = view('admin.generations.table', compact('generations'))->render();
            return response()->json(['message' => 'Generation created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create generation'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $generation = Generation::findOrFail($id);
            return response()->json(['generation' => $generation], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch generation details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Generation $generation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'model_id' => 'required',
        ]);

        try {
            $generation->update($request->all());

            if ($generation->wasChanged()) {
                $generations = Generation::all();
                $view = view('admin.generations.table', compact('generations'))->render();
                return response()->json(['message' => 'Generation updated successfully', 'generations' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the generation'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update generation: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Generation $generation)
    {
        try {
            $generation->delete();
            $generations = Generation::all();
            $view = view('admin.generations.table', compact('generations'))->render();
            return response()->json(['message' => 'Generation deleted successfully', 'generations' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete generation: ' . $e->getMessage()], 500);
        }
    }
}
