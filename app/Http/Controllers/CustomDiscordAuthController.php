<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CustomDiscordAuthController extends Controller
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $server_id;
    protected $discord_api_url;
    protected $discord_roles;

    public function __construct()
    {
        $this->client_id = config('discord.client_id');
        $this->client_secret = config('discord.client_secret');
        $this->redirect_uri = config('discord.redirect_uri');
        $this->server_id = config('discord.server_id');
        $this->discord_api_url = config('discord.api_base_url');
        $this->discord_roles = config('discord.roles');
    }

    public function redirect()
    {
        $state = Str::random(40);
        session(['discord_state' => $state]);

        $query = http_build_query([
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code',
            'scope' => 'identify email guilds.members.read',
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
        
        // Get user's guild membership details
        $guildMemberResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokens['access_token']
        ])->get($this->discord_api_url . '/users/@me/guilds/' . $this->server_id . '/member');
        
        // Initialize user roles
        $userRoles = [];
        $premiumType = null;
        $isAdmin = false;
        
        // Process guild membership if successful
        if ($guildMemberResponse->successful()) {
            $guildMember = $guildMemberResponse->json();
            
            if (isset($guildMember['roles'])) {
                $userRoles = $guildMember['roles'];
                
                // Check for admin role
                if (in_array($this->discord_roles['admin'], $userRoles)) {
                    $isAdmin = true;
                }
                
                // Determine premium type
                if (in_array($this->discord_roles['premium'], $userRoles)) {
                    $premiumType = 'All';
                } elseif (in_array($this->discord_roles['external'], $userRoles)) {
                    $premiumType = 'External';
                } elseif (in_array($this->discord_roles['streamer'], $userRoles)) {
                    $premiumType = 'Streamer';
                } elseif (in_array($this->discord_roles['bypass'], $userRoles)) {
                    $premiumType = 'Bypass';
                } elseif (in_array($this->discord_roles['reseller'], $userRoles)) {
                    $premiumType = 'Reseller';
                }
            }
        } else {
            Log::warning('Could not fetch guild membership details for user', [
                'user_id' => $discordUser['id'],
                'guild_id' => $this->server_id,
                'response' => $guildMemberResponse->body()
            ]);
        }
        
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
                'discord_avatar' => isset($discordUser['avatar']) ? 'https://cdn.discordapp.com/avatars/' . $discordUser['id'] . '/' . $discordUser['avatar'] . '.png' : null,
                'email_verified_at' => now(),
                'role' => $isAdmin ? 'admin' : 'user',
                'premium_type' => $premiumType,
                'is_reseller' => $premiumType === 'Reseller',
                'max_clients' => $premiumType === 'Reseller' ? 10 : 0,
            ]);
        } else {
            // Update existing user with latest Discord info
            $user->update([
                'discord_username' => $discordUser['username'],
                'discord_avatar' => isset($discordUser['avatar']) ? 'https://cdn.discordapp.com/avatars/' . $discordUser['id'] . '/' . $discordUser['avatar'] . '.png' : null,
                'role' => $isAdmin ? 'admin' : $user->role,
                'premium_type' => $premiumType !== null ? $premiumType : $user->premium_type,
                'is_reseller' => $premiumType === 'Reseller' ? true : ($user->premium_type === 'Reseller'),
            ]);
        }

        // Log in the user
        Auth::login($user);
        
        return redirect()->intended(route('dashboard'));
    }
} 