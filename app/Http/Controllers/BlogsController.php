<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class BlogsController extends Controller
{
    //
    public function index(Request $request)
    {
        $blogs = Blogs::with("category","user");
        if ($request->has('search') && $request->search != null && $request->search != '') {
            $blogs = $blogs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $blogs = $blogs->paginate(10);
        if ($request->has("type")) {
            return $blogs;
        }
        return view('dashboard.admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $user = User::where('role_id', '!=', 1)->get();
        $categories = Category::where('type', 'blogging')->get();
        return view('dashboard.admin.blogs.create', compact('categories', 'user'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|unique:blogs',
                'image' => 'required|image|max:2048',
                'description' => 'required',
                'status' => 'required|in:0,1',
                'category_id' => [
                        'required',
                        'exists:categories,id'
                    ]
            ]);
            if (auth()->user()->role_id == 1) {
                $request->validate([
                    'user_id' => [
                        'required',
                        'exists:users,id'
                    ]
                ]);
            }

            $blogs = new Blogs();
            $blogs->user_id = $request->user_id;
            $blogs->category_id = $request->category_id;
            $blogs->title = $request->title;
            $blogs->slug = Str::slug($request->title, '-');
            $blogs->image = $request->file('image')->store('images/blogs');
            $blogs->description = $request->description;
            $blogs->status = $request->status;
            $blogs->save();
            return redirect()->route('blogs.index')->with('success', 'Blog created successfully...');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Blogs $blogs)
    {
        return view('dashboard.admin.blogs.edit', compact('model'));
    }

    public function update(Request $request, Blogs $blogs)
    {
        try {
        $request->validate([
            'title' => 'required|unique:blogs,title,' . $blogs->id,
            'image' => 'image|max:2048',
            'description' => 'required',
            'status' => 'required|in:0,1',
            'category_id' => [
                    'required',
                    'exists:categories,id'
                ]
        ]);
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'user_id' => [
                    'required',
                    'exists:users,id'
                ]
            ]);
        }

        $blogs->title = $request->title;
        $blogs->slug = Str::slug($request->title, '-');
        $blogs->user_id = $request->user_id;
        $blogs->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $blogs->image = $request->file('image')->store('images/blogs');
        }
        $blogs->description = $request->description;
        $blogs->status = $request->status;
        $blogs->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Blogs $blogs)
    {
        $blogs->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
