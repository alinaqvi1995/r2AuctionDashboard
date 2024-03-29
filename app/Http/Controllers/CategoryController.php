<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjusted validation for image upload
        ]);

        if ($request->hasFile('icon')) {
            $img = $request->icon;
            $number = rand(1, 999);
            $numb = $number / 7;
            $extension = $img->extension();
            $filenamenew = date('Y-m-d') . "_." . $numb . "_." . $extension;
            $filenamepath = 'category_icons' . '/' . 'img/' . $filenamenew;
            $filename = $img->move(public_path('storage/category_icons' . '/' . 'img'), $filenamenew);
            $iconPath = $filenamepath;
        }

        $categories = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        if ($categories) {
            $categories = Category::all();
            $view = view('admin.categories.table', compact('categories'))->render();
            return response()->json(['message' => 'Category created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $categories = Category::findOrFail($id);
            return response()->json(['category' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            if ($request->hasFile('icon')) {
                $img = $request->file('icon');
                $number = rand(1, 999);
                $numb = $number / 7;
                $extension = $img->getClientOriginalExtension();
                $filenamenew = date('Y-m-d') . "_." . $numb . "_." . $extension;
                $filenamepath = 'category_icons' . '/' . 'img/' . $filenamenew;
                $filename = $img->move(public_path('storage/category_icons' . '/' . 'img'), $filenamenew);
                $data['icon'] = $filenamepath;
            }

            $category->update($data);

            if ($category->wasChanged()) {
                $categories = Category::all();
                $view = view('admin.categories.table', compact('categories'))->render();
                return back()->with(['message' => 'Category updated successfully', 'categories' => $view], 200);
            } else {
                return back()->with(['error' => 'No changes detected for the category'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Category $categories)
    {
        try {
            // Delete the category's icon file before deleting the category
            if ($categories->icon) {
                \Storage::delete($categories->icon);
            }
            $categories->delete();
            $categories = Category::all();
            $view = view('admin.categories.table', compact('categories'))->render();
            return response()->json(['message' => 'Category deleted successfully', 'categories' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category: ' . $e->getMessage()], 500);
        }
    }
}
