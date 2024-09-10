<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

            // Check if user exists, if not create a new user
            $user = User::firstOrCreate(
                ['email' => $userInfo->email],
                ['name' => $userInfo->name, 'password' => bcrypt(str_random(16))]
            );

            // Log in the user
            Auth::login($user);

            return response()->json(['message' => 'User logged in successfully', 'user' => $user]);
        }

        return response()->json(['error' => 'Authentication failed'], 401);
    }
}
