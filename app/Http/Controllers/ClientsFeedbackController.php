<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientsFeedback;
use App\Traits\ImageTrait;

class ClientsFeedbackController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $feedbacks = ClientsFeedback::all();
        return view('admin.clients_feedback.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'clients_feedback');
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        $feedback = ClientsFeedback::create(array_merge(
            $request->except('image'),
            ['image' => $imagePath]
        ));

        if ($feedback) {
            $feedbacks = ClientsFeedback::all();
            $view = view('admin.clients_feedback.table', compact('feedbacks'))->render();
            return response()->json(['message' => 'Feedback created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create feedback'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $feedback = ClientsFeedback::findOrFail($id);
            return response()->json(['feedback_item' => $feedback], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch feedback details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, ClientsFeedback $feedback)
    {
        $request->validate([
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'required|integer|between:1,5',
            'status' => 'required|boolean',
        ]);

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'), 'clients_feedback');
                $data['image'] = $imagePath;
            }

            $feedback->update($data);

            if ($feedback->wasChanged()) {
                $feedbacks = ClientsFeedback::all();
                $tableHtml = view('admin.clients_feedback.table', compact('feedbacks'))->render();
                return response()->json(['message' => 'Feedback updated successfully', 'table_html' => $tableHtml], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the feedback item'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update feedback: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(ClientsFeedback $feedback)
    {
        try {
            $feedback->delete();
            $feedbacks = ClientsFeedback::all();
            $view = view('admin.clients_feedback.table', compact('feedbacks'))->render();
            return response()->json(['message' => 'Feedback deleted successfully', 'table_html' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete feedback: ' . $e->getMessage()], 500);
        }
    }
}
