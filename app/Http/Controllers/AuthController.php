<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PasswordChanged;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Send password reset link to email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent'], 200);
        }

        return response()->json(['message' => 'Unable to send reset link'], 400);
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        \Log::debug('Reset Password Route Accessed');
        dd($request->toArray());
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                dd($user->name);

                try {
                    // Sending email after password is reset
                    Mail::to($user->email)->send(new PasswordChanged($user->name));
                } catch (\Exception $e) {
                    \Log::error('Failed to send password changed email: ' . $e->getMessage());
                }
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully'], 200);
        }

        return response()->json(['message' => 'Failed to reset password'], 400);
    }
}
