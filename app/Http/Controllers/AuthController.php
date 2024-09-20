<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent'], 200);
        }

        if ($status === Password::INVALID_USER) {
            return response()->json(['message' => 'No user found with that email address'], 404);
        }

        if ($status === Password::RESET_THROTTLED) {
            $waitTime = config('auth.passwords.' . config('auth.defaults.passwords') . '.throttle') / 60;
            return response()->json(['message' => "Too many attempts. Please wait for {$waitTime} minutes before trying again."], 429);
        }

        return response()->json(['message' => 'Unable to send reset link'], 400);
    }


    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully'], 200);
        }

        if ($status === Password::INVALID_TOKEN) {
            return response()->json(['message' => 'This link has expired.'], 400);
        }

        return response()->json(['message' => 'Failed to reset password'], 400);
    }
}
