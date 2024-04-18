<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'business_email' => ['required', 'string', 'email', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'business_website' => ['required', 'string', 'max:255'],
            'business_desc' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:buyer,seller'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'address' => $request->input('address'),
            'business_name' => $request->input('business_name'),
            'business_email' => $request->input('business_email'),
            'designation' => $request->input('designation'),
            'business_website' => $request->input('business_website'),
            'business_desc' => $request->input('business_desc'),
            'role' => $request->input('role'),
        ]);

        // Return success response with user data
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}
