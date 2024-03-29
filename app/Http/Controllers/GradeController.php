<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::all();
        return view('admin.grades.index', compact('grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $grade = Grade::create($request->all());

        if ($grade) {
            $grades = Grade::all();
            $view = view('admin.grades.table', compact('grades'))->render();
            return response()->json(['message' => 'Grade created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create grade'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            return response()->json(['grade' => $grade], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch grade details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $grade->update($request->all());

            if ($grade->wasChanged()) {
                $grades = Grade::all();
                $table_html = view('admin.grades.table', compact('grades'))->render();
                return back()->with(['message' => 'Grade updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the grade'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update grade: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            $grades = Grade::all();
            $view = view('admin.grades.table', compact('grades'))->render();
            return response()->json(['message' => 'Grade deleted successfully', 'grades' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete grade: ' . $e->getMessage()], 500);
        }
    }
}
