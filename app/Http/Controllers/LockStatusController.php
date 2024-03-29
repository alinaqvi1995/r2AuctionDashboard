<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LockStatus;

class LockStatusController extends Controller
{
    public function index()
    {
        $lockStatuses = LockStatus::all();
        return view('admin.lock_statuses.index', compact('lockStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $lockStatus = LockStatus::create($request->all());

        if ($lockStatus) {
            $lockStatuses = LockStatus::all();
            $view = view('admin.lock_statuses.table', compact('lockStatuses'))->render();
            return response()->json(['message' => 'Lock Status created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create lock status'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $lockStatus = LockStatus::findOrFail($id);
            return response()->json(['lockStatus' => $lockStatus], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch lock status details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, LockStatus $lockStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        try {
            $lockStatus->update($request->all());

            if ($lockStatus->wasChanged()) {
                $lockStatuses = LockStatus::all();
                $table_html = view('admin.lock_statuses.table', compact('lockStatuses'))->render();
                return back()->with(['message' => 'Lock Status updated successfully', 'table_html' => $table_html], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the lock status'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update lock status: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(LockStatus $lockStatus)
    {
        try {
            $lockStatus->delete();
            $lockStatuses = LockStatus::all();
            $view = view('admin.lock_statuses.table', compact('lockStatuses'))->render();
            return response()->json(['message' => 'Lock Status deleted successfully', 'lockStatuses' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete lock status: ' . $e->getMessage()], 500);
        }
    }
}
