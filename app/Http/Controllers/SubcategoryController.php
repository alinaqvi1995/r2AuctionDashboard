<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::all();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
        ]);

        $subcategory = Subcategory::create($request->all());

        if ($subcategory) {
            $subcategories = Subcategory::all();
            $view = view('admin.subcategories.table', compact('subcategories'))->render();
            return response()->json(['message' => 'Subcategory created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create subcategory'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $subcategory = Subcategory::findOrFail($id);
            return response()->json(['subcategory' => $subcategory], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch subcategory details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
        ]);

        try {
            $subcategory->update($request->all());

            if ($subcategory->wasChanged()) {
                $subcategories = Subcategory::all();
                $view = view('admin.subcategories.table', compact('subcategories'))->render();
                return response()->json(['message' => 'Subcategory updated successfully', 'subcategories' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the subcategory'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update subcategory: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Subcategory $subcategory)
    {
        try {
            $subcategory->delete();
            $subcategories = Subcategory::all();
            $view = view('admin.subcategories.table', compact('subcategories'))->render();
            return response()->json(['message' => 'Subcategory deleted successfully', 'subcategories' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete subcategory: ' . $e->getMessage()], 500);
        }
    }

    public function getByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        return response()->json(['subcategories' => $subcategories], 200);
    }

}
