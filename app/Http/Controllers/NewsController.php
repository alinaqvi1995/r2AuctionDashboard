<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Traits\ImageTrait;

class NewsController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'news');
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        $news = News::create(array_merge(
            $request->except('image'),
            ['image' => url('/') . '/' . $imagePath]
        ));

        if ($news) {
            $news = News::all();
            $view = view('admin.news.table', compact('news'))->render();
            return response()->json(['message' => 'News item created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create news item'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $news = News::findOrFail($id);
            return response()->json(['news_item' => $news], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch news item details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'), 'news');
                $data['image'] = url('/') . '/' . $imagePath;
            }

            $news->update($data);

            if ($news->wasChanged()) {
                $news = News::all();
                $tableHtml = view('admin.news.table', compact('news'))->render();
                return response()->json(['message' => 'News item updated successfully', 'table_html' => $tableHtml], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the news item'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update news item: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(News $news)
    {
        try {
            $news->delete();
            $news = News::all();
            $view = view('admin.news.table', compact('news'))->render();
            return response()->json(['message' => 'News item deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete news item: ' . $e->getMessage()], 500);
        }
    }
}
