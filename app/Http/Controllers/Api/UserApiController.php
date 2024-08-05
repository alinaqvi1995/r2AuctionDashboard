<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = User::with('buyer', 'seller')->findOrFail($id);
        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'full_name' => $validatedData['name'] . ' ' . $validatedData['middle_name'] . ' ' . $validatedData['last_name'],
            'phone' => $validatedData['phone'],
            'state' => $validatedData['state'],
            'city' => $validatedData['city'],
            'address' => $validatedData['address'],
            'business_name' => $validatedData['business_name'],
            'business_email' => $validatedData['business_email'],
            'designation' => $validatedData['designation'],
            'business_website' => $validatedData['business_website'],
            'business_desc' => $validatedData['business_desc'],
            'role' => $validatedData['role'],
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'middle_name' => 'sometimes|nullable|string|max:255',
            'last_name' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'state' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:255',
            'address' => 'sometimes|nullable|string|max:255',
            'business_name' => 'sometimes|nullable|string|max:255',
            'business_email' => 'sometimes|nullable|string|email|max:255',
            'designation' => 'sometimes|nullable|string|max:255',
            'business_website' => 'sometimes|nullable|string|max:255',
            'business_desc' => 'sometimes|nullable|string|max:500',
            'role' => 'sometimes|nullable|string|max:50',
        ]);

        $user = User::findOrFail($id);

        $user->fill($validatedData);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
