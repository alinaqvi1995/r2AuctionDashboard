<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
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

            Notification::create([
                'user_id' => $user->id,
                'title' => 'New User Registration',
                'description' => 'A new user has registered: ' . $user->email . 'with Google Auth',
                'link' => route('users.index'),
                'is_read' => 0,
            ]);

            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            if ($user->wasRecentlyCreated) {
                Mail::to($user->email)->send(new UserSignedUp($user));

                $userData = [
                    'message' => 'User registered successfully',
                    'token' => $token,
                    'user' => $user
                ];

                return response()->view('auth.google_callback', ['userData' => json_encode($userData)]);
            } else {
                Mail::to($user->email)->send(new UserSignedIn($user));

                $userData = [
                    'message' => 'User logged in successfully',
                    'token' => $token,
                    'user' => $user
                ];

                return response()->view('auth.google_callback', ['userData' => json_encode($userData)]);
            }
        }

        return response()->json(['error' => 'Authentication failed'], 401);
    }
}
