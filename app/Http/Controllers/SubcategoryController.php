<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::all();
        $categories = Category::all();
        return view('dashboard.admin.subcategories.index', compact('categories', 'subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'slug' => 'required|unique:subcategories',
            'description' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        $subcategory = Subcategory::create($data);

        if ($subcategory) {
            return response()->json(['success' => 'Subcategory created successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to create subcategory'], 500);
        }
    }

    public function show(Subcategory $subcategory)
    {
        return response()->json($subcategory);
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('dashboard.admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',
            'slug' => 'required|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable',
            'status' => 'required|in:active,inactive',
        ]);

        $subcategory->fill($request->all());
        $updated = $subcategory->save();

        if ($updated) {
            return response()->json(['success' => 'Subcategory updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to update subcategory'], 500);
        }
    }

    public function destroy(Subcategory $subcategory)
    {
        $deleted = $subcategory->delete();

        if ($deleted) {
            return response()->json(['success' => 'Subcategory deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to delete subcategory'], 500);
        }
    }
}
