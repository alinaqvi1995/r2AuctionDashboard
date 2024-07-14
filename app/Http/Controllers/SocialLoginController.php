<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        // Check if the user exists in the database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // User exists, log in the user
            $token = $existingUser->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'Login successful', 'user' => $existingUser, 'token' => $token], 200);
        } else {
            // User does not exist, create a new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                // Add other necessary fields
            ]);

            // Generate token for the new user
            $token = $newUser->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'User registered and logged in successfully', 'user' => $newUser, 'token' => $token], 201);
        }
    }
}
