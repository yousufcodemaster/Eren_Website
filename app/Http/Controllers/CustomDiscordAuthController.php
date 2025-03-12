<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CustomDiscordAuthController extends Controller
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $discord_api_url = 'https://discord.com/api';

    public function __construct()
    {
        $this->client_id = config('services.discord.client_id');
        $this->client_secret = config('services.discord.client_secret');
        $this->redirect_uri = config('services.discord.redirect');
    }

    public function redirect()
    {
        $state = Str::random(40);
        session(['discord_state' => $state]);

        $query = http_build_query([
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => 'identify email',
            'state' => $state,
        ]);

        return redirect($this->discord_api_url . '/oauth2/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $state = session('discord_state');
        
        // Validate state to prevent CSRF
        if (!$state || $state !== $request->state) {
            return redirect()->route('login')->with('error', 'Invalid state parameter. Authentication failed.');
        }

        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Discord authentication denied.');
        }

        if (!$request->has('code')) {
            return redirect()->route('login')->with('error', 'No authorization code provided.');
        }

        // Exchange code for token
        $response = Http::post($this->discord_api_url . '/oauth2/token', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => $this->redirect_uri,
        ]);

        if (!$response->successful()) {
            return redirect()->route('login')->with('error', 'Failed to obtain access token.');
        }

        $tokens = $response->json();
        
        // Get user details with token
        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokens['access_token']
        ])->get($this->discord_api_url . '/users/@me');

        if (!$userResponse->successful()) {
            return redirect()->route('login')->with('error', 'Failed to retrieve user information.');
        }

        $discordUser = $userResponse->json();
        
        // Find or create user
        $user = User::where('discord_id', $discordUser['id'])->first();
        
        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $discordUser['username'],
                'email' => $discordUser['email'] ?? $discordUser['id'] . '@discord.user',
                'password' => bcrypt(Str::random(16)),
                'discord_id' => $discordUser['id'],
                'discord_username' => $discordUser['username'],
                'discord_avatar' => $discordUser['avatar'],
                'email_verified_at' => now(),
            ]);
        } else {
            // Update existing user with latest Discord info
            $user->update([
                'discord_username' => $discordUser['username'],
                'discord_avatar' => $discordUser['avatar'],
            ]);
        }

        // Log in the user
        Auth::login($user);
        
        return redirect()->intended(route('dashboard'));
    }
} 