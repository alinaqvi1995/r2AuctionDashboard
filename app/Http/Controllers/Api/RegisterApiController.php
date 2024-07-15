<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterApiController extends Controller
{
    public function register(Request $request)
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
            'role' => 'nullable|string|in:admin,buyer,seller,user|max:50',
        ]);

        $user = User::create([
            'name' => $validatedData['name'] ?? '',
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'middle_name' => $validatedData['middle_name'] ?? '',
            'last_name' => $validatedData['last_name'] ?? '',
            'full_name' => trim(($validatedData['name'] ?? '') . ' ' . ($validatedData['middle_name'] ?? '') . ' ' . ($validatedData['last_name'] ?? '')),
            'phone' => $validatedData['phone'] ?? '',
            'state' => $validatedData['state'] ?? '',
            'city' => $validatedData['city'] ?? '',
            'address' => $validatedData['address'] ?? '',
            'business_name' => $validatedData['business_name'] ?? '',
            'business_email' => $validatedData['business_email'] ?? '',
            'designation' => $validatedData['designation'] ?? '',
            'business_website' => $validatedData['business_website'] ?? '',
            'business_desc' => $validatedData['business_desc'] ?? '',
            'role' => $validatedData['role'] ?? 'user',
        ]);

        // Return success response with user data
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'middle_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:255'],
            'state' => ['sometimes', 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:255'],
            'business_name' => ['sometimes', 'string', 'max:255'],
            'business_email' => ['sometimes', 'string', 'email', 'max:255'],
            'designation' => ['sometimes', 'string', 'max:255'],
            'business_website' => ['sometimes', 'string', 'max:255'],
            'business_desc' => ['sometimes', 'string', 'max:255'],
            'role' => ['sometimes', 'string', 'in:buyer,seller'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
}
