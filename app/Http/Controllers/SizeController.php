<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $size = Size::create($request->all());

        if ($size) {
            $sizes = Size::all();
            $view = view('admin.sizes.table', compact('sizes'))->render();
            return response()->json(['message' => 'Size created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create size'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $size = Size::findOrFail($id);
            return response()->json(['size' => $size], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch size details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $size->update($request->all());

            if ($size->wasChanged()) {
                $sizes = Size::all();
                $table_html = view('admin.sizes.table', compact('sizes'))->render();
                return response()->json(['message' => 'Size updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the size'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update size: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Size $size)
    {
        try {
            $size->delete();
            $sizes = Size::all();
            $view = view('admin.sizes.table', compact('sizes'))->render();
            return response()->json(['message' => 'Size deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete size: ' . $e->getMessage()], 500);
        }
    }
}
