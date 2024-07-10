<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    // Get all users
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    // Get a single user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    // Store a new user
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'business_email' => 'nullable|string|email|max:255',
            'designation' => 'nullable|string|max:255',
            'business_website' => 'nullable|string|max:255',
            'business_desc' => 'nullable|string|max:500',
            'role' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'business_name' => $request->business_name,
            'business_email' => $request->business_email,
            'designation' => $request->designation,
            'business_website' => $request->business_website,
            'business_desc' => $request->business_desc,
            'role' => $request->role,
        ]);

        return response()->json($user, 201);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'middle_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'state' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'business_name' => 'sometimes|required|string|max:255',
            'business_email' => 'sometimes|required|string|email|max:255',
            'designation' => 'sometimes|required|string|max:255',
            'business_website' => 'sometimes|required|string|max:255',
            'business_desc' => 'sometimes|required|string|max:500',
            'role' => 'sometimes|required|string|max:50',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
