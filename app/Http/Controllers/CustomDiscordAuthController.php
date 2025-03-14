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

        // Debug information
        Log::debug('Discord OAuth2 Redirect', [
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'server_id' => $this->server_id
        ]);

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
        
        // Add initial debug log
        Log::debug('Discord callback started', ['request' => $request->all()]);
        
        // Validate state to prevent CSRF
        if (!$state || $state !== $request->state) {
            Log::error('Invalid state parameter', ['session_state' => $state, 'request_state' => $request->state]);
            return redirect()->route('login')->with('error', 'Invalid state parameter. Authentication failed.');
        }

        if ($request->has('error')) {
            Log::error('Discord authentication denied', ['error' => $request->error]);
            return redirect()->route('login')->with('error', 'Discord authentication denied.');
        }

        if (!$request->has('code')) {
            Log::error('No authorization code provided');
            return redirect()->route('login')->with('error', 'No authorization code provided.');
        }

        // Exchange code for token
        Log::debug('Attempting to exchange code for token', [
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'code_length' => strlen($request->code)
        ]);
        
        $response = Http::post($this->discord_api_url . '/oauth2/token', [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => $this->redirect_uri,
        ]);

        if (!$response->successful()) {
            Log::error('Failed to obtain access token', [
                'response_status' => $response->status(),
                'response_body' => $response->body(),
                'client_id' => $this->client_id,
                'redirect_uri' => $this->redirect_uri
            ]);
            return redirect()->route('login')->with('error', 'Failed to obtain access token. Error: ' . $response->body());
        }

        $tokens = $response->json();
        Log::debug('Access token obtained successfully');
        
        // Get user details with token
        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokens['access_token']
        ])->get($this->discord_api_url . '/users/@me');

        if (!$userResponse->successful()) {
            Log::error('Failed to retrieve user information', ['response' => $userResponse->body()]);
            return redirect()->route('login')->with('error', 'Failed to retrieve user information.');
        }

        $discordUser = $userResponse->json();
        Log::debug('Discord user retrieved', ['username' => $discordUser['username'], 'id' => $discordUser['id']]);
        
        // Get user's guild membership details
        $guildMemberResponse = Http::withHeaders([
            'Authorization' => 'Bot ' . config('discord.bot_token')
        ])->get($this->discord_api_url . '/guilds/' . $this->server_id . '/members/' . $discordUser['id']);
        
        // Initialize user roles
        $userRoles = [];
        $premiumType = null;
        $isAdmin = false;
        
        // Process guild membership if successful
        if ($guildMemberResponse->successful()) {
            $guildMember = $guildMemberResponse->json();
            Log::debug('Guild member info retrieved', ['guildMember' => $guildMember]);
            
            if (isset($guildMember['roles'])) {
                $userRoles = $guildMember['roles'];
                Log::debug('User roles retrieved', ['roles' => $userRoles]);
                
                // Check for admin role
                if (in_array($this->discord_roles['admin'], $userRoles)) {
                    $isAdmin = true;
                    Log::debug('User has admin role');
                }
                
                // Determine premium type
                if (in_array($this->discord_roles['premium'], $userRoles)) {
                    $premiumType = 'All';
                    Log::debug('User has Premium All role');
                } elseif (in_array($this->discord_roles['external'], $userRoles)) {
                    $premiumType = 'External';
                    Log::debug('User has External role');
                } elseif (in_array($this->discord_roles['streamer'], $userRoles)) {
                    $premiumType = 'Streamer';
                    Log::debug('User has Streamer role');
                } elseif (in_array($this->discord_roles['bypass'], $userRoles)) {
                    $premiumType = 'Bypass';
                    Log::debug('User has Bypass role');
                } elseif (in_array($this->discord_roles['reseller'], $userRoles)) {
                    $premiumType = 'Reseller';
                    Log::debug('User has Reseller role');
                }
            } else {
                Log::warning('User has no roles in the guild', ['guild_id' => $this->server_id]);
            }
        } else {
            Log::warning('Could not fetch guild membership details for user', [
                'user_id' => $discordUser['id'],
                'guild_id' => $this->server_id,
                'response' => $guildMemberResponse->status() . ': ' . $guildMemberResponse->body(),
                'request_url' => $this->discord_api_url . '/guilds/' . $this->server_id . '/members/' . $discordUser['id']
            ]);
            
            // The user might not be in the server, let them login with basic permissions
            // We'll show them a message to join the server for full access
        }
        
        // Find or create user
        $user = User::where('discord_id', $discordUser['id'])->first();
        
        try {
            if (!$user) {
                // Create a new user
                Log::debug('Creating new user', [
                    'username' => $discordUser['username'],
                    'email' => $discordUser['email'] ?? $discordUser['id'] . '@discord.user',
                    'role' => $isAdmin ? 'admin' : 'user',
                    'premium_type' => $premiumType
                ]);
                
                // Make sure we have an email
                $email = isset($discordUser['email']) ? $discordUser['email'] : $discordUser['id'] . '@discord.user';
                
                $user = User::create([
                    'name' => $discordUser['username'] ?? 'Discord User',
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                    'discord_id' => $discordUser['id'],
                    'discord_username' => $discordUser['username'] ?? 'Discord User',
                    'discord_avatar' => isset($discordUser['avatar']) ? 'https://cdn.discordapp.com/avatars/' . $discordUser['id'] . '/' . $discordUser['avatar'] . '.png' : null,
                    'email_verified_at' => now(),
                    'role' => $isAdmin ? 'admin' : 'user',
                    'premium_type' => $premiumType,
                    'is_reseller' => $premiumType === 'Reseller',
                    'max_clients' => $premiumType === 'Reseller' ? 10 : 0,
                ]);
                
                Log::debug('New user created successfully', ['user_id' => $user->id]);
            } else {
                // Update existing user with latest Discord info
                Log::debug('Updating existing user', ['user_id' => $user->id]);
                
                $user->update([
                    'discord_username' => $discordUser['username'] ?? $user->discord_username,
                    'discord_avatar' => isset($discordUser['avatar']) ? 'https://cdn.discordapp.com/avatars/' . $discordUser['id'] . '/' . $discordUser['avatar'] . '.png' : $user->discord_avatar,
                    'role' => $isAdmin ? 'admin' : $user->role,
                    'premium_type' => $premiumType !== null ? $premiumType : $user->premium_type,
                    'is_reseller' => $premiumType === 'Reseller' ? true : ($user->premium_type === 'Reseller'),
                ]);
                
                Log::debug('User updated successfully');
            }

            // Log in the user
            Auth::login($user);
            Log::debug('User logged in successfully', ['user_id' => $user->id]);
            
            // Check if the user is an admin
            if ($user->role === 'admin') {
                Log::debug('Redirecting admin user to admin dashboard');
                return redirect()->route('admin.dashboard');
            }
            
            // Check if the user is a reseller
            if ($user->is_reseller) {
                Log::debug('Redirecting reseller user to reseller dashboard');
                return redirect()->route('reseller.dashboard');
            }
            
            // For regular users, use a direct redirect instead of 'intended'
            Log::debug('Redirecting regular user to dashboard');
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            Log::error('Error creating/updating user', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'discord_user' => $discordUser
            ]);
            
            return redirect()->route('login')->with('error', 'Failed to create user account: ' . $e->getMessage());
        }
    }
} 