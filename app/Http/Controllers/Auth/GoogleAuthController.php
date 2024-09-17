<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\UserSignedIn;
use App\Mail\UserSignedUp;
use Illuminate\Support\Facades\Mail;

class GoogleAuthController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $this->client->addScope(Oauth2::USERINFO_EMAIL);
        $this->client->addScope(Oauth2::USERINFO_PROFILE);
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return response()->json(['url' => $authUrl]);
    }

    public function handleGoogleCallback(Request $request)
    {
        if ($request->has('code')) {
            $this->client->fetchAccessTokenWithAuthCode($request->code);
            $oauth2 = new Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();

            $user = User::firstOrCreate(
                ['email' => $userInfo->email],
                [
                    'name' => $userInfo->name,
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'user',
                    'status' => 0,
                    'avatar' => $userInfo->picture,
                    'admin_approval' => 0
                ]
            );

            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            $redirectUrl = 'http://localhost:3000/buyer/dashboard';
            
            if ($user->wasRecentlyCreated) {
                Mail::to($user->email)->send(new UserSignedUp($user));
                // return response()->json([
                //     'message' => 'User registered successfully',
                //     'token' => $token,
                //     'user' => $user,
                // ], 201);
                return redirect($redirectUrl)->with([
                    'message' => 'User registered successfully',
                    'token' => $token,
                    'user' => $user
                ]);
            } else {
                Mail::to($user->email)->send(new UserSignedIn($user));
                // return redirect()->url($redirectUrl)->response()->json([
                //     'message' => 'User logged in successfully',
                //     'token' => $token,
                //     'user' => $user,
                // ], 200);
                return redirect($redirectUrl)->with([
                    'message' => 'User logged in successfully',
                    'token' => $token,
                    'user' => $user
                ]);
            }
        }

        return response()->json(['error' => 'Authentication failed'], 401);
    }
}
