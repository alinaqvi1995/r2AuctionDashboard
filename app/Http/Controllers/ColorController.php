<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'color_code' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $color = Color::create($request->all());

        if ($color) {
            $colors = Color::all();
            $view = view('admin.colors.table', compact('colors'))->render();
            return response()->json(['message' => 'Color created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create color'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $color = Color::findOrFail($id);
            return response()->json(['color' => $color], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch color details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'color_code' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $color->update($request->all());

            if ($color->wasChanged()) {
                $colors = Color::all();
                $view = view('admin.colors.table', compact('colors'))->render();
                return response()->json(['message' => 'Color updated successfully', 'colors' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the color'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update color: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Color $color)
    {
        try {
            $color->delete();
            $colors = Color::all();
            $view = view('admin.colors.table', compact('colors'))->render();
            return response()->json(['message' => 'Color deleted successfully', 'colors' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete color: ' . $e->getMessage()], 500);
        }
    }
}
