<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DiscordAuthController extends Controller
{
    // Discord Role IDs
    protected $roleIds = [
        'admin' => '1348977595580026880',
        'premium' => '1348987964637708368',
        'external' => '1348988317441589290',
        'streamer' => '1348988483653472327',
        'bypass' => '1348988558240776304',
        'reseller' => '1348988660930052128',
    ];

    // Guild ID
    protected $guildId = '823837742391492609';

    /**
     * Redirect the user to the Discord authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        $state = Str::random(40);
        session(['discord_state' => $state]);

        $query = http_build_query([
            'client_id' => config('services.discord.client_id'),
            'redirect_uri' => config('services.discord.redirect'),
            'response_type' => 'code',
            'scope' => 'identify email guilds.members.read',
            'state' => $state,
        ]);

        return redirect('https://discord.com/api/oauth2/authorize?' . $query);
    }

    /**
     * Obtain the user information from Discord.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        try {
            if ($request->get('state') !== session('discord_state')) {
                return redirect()->route('login')->with('error', 'Invalid state parameter.');
            }

            $tokenResponse = $this->getAccessTokenResponse($request->get('code'));
            if (!$tokenResponse || !isset($tokenResponse['access_token'])) {
                return redirect()->route('login')->with('error', 'Failed to get access token.');
            }

            $token = $tokenResponse['access_token'];
            
            $discordUser = $this->getDiscordUser($token);
            if (!$discordUser) {
                return redirect()->route('login')->with('error', 'Failed to get user information.');
            }
            
            // Get user's roles from the Discord server
            $userRoles = $this->getUserRoles($token, $discordUser['id']);
            
            // Determine user type based on roles
            $userType = $this->determineUserType($userRoles);
            $isAdmin = $this->hasRole($userRoles, $this->roleIds['admin']);
            $isReseller = $this->hasRole($userRoles, $this->roleIds['reseller']);
            
            // Check if user exists
            $user = User::where('discord_id', $discordUser['id'])->first();
            
            if ($user) {
                // Update existing user with latest info from Discord
                $user->discord_avatar = $this->getDiscordAvatar($discordUser);
                $user->discord_username = $discordUser['username'] . '#' . $discordUser['discriminator'];
                
                // Update role and premium type based on Discord roles
                if ($isAdmin) {
                    $user->role = 'admin';
                } else {
                    $user->role = 'user';
                }
                
                $user->premium_type = $userType;
                $user->is_reseller = $isReseller;
                
                // Set max_clients for resellers if not already set
                if ($isReseller && (!$user->max_clients || $user->max_clients < 1)) {
                    $user->max_clients = 10; // Default value for new resellers
                }
                
                $user->save();
                
                // Login user
                Auth::login($user);
                
                // Redirect based on user role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                return redirect()->intended(route('dashboard'));
            } else {
                // Create new user
                $user = User::create([
                    'name' => $discordUser['username'] ?? 'Discord User',
                    'email' => $discordUser['email'],
                    'password' => bcrypt(Str::random(16)),
                    'discord_id' => $discordUser['id'],
                    'discord_username' => $discordUser['username'] . '#' . $discordUser['discriminator'], 
                    'discord_avatar' => $this->getDiscordAvatar($discordUser),
                    'email_verified_at' => now(),
                    'role' => $isAdmin ? 'admin' : 'user',
                    'premium_type' => $userType,
                    'is_reseller' => $isReseller,
                    'max_clients' => $isReseller ? 10 : 0, // Default 10 clients for resellers
                ]);
                
                Auth::login($user);
                return redirect()->intended(route('dashboard'));
            }
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Discord authentication failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the access token response.
     *
     * @param string $code
     * @return array|null
     */
    protected function getAccessTokenResponse($code)
    {
        $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => config('services.discord.client_id'),
            'client_secret' => config('services.discord.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.discord.redirect'),
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Get the user information from Discord.
     *
     * @param string $token
     * @return array|null
     */
    protected function getDiscordUser($token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://discord.com/api/users/@me');

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Get user's roles in the Discord server.
     *
     * @param string $token
     * @param string $userId
     * @return array
     */
    protected function getUserRoles($token, $userId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("https://discord.com/api/users/@me/guilds/{$this->guildId}/member");

        if ($response->failed()) {
            return [];
        }

        $member = $response->json();
        return $member['roles'] ?? [];
    }

    /**
     * Determine the user's premium type based on their Discord roles.
     *
     * @param array $roles
     * @return string|null
     */
    protected function determineUserType($roles)
    {
        if ($this->hasRole($roles, $this->roleIds['reseller'])) {
            return 'Reseller';
        } elseif ($this->hasRole($roles, $this->roleIds['bypass'])) {
            return 'Bypass';
        } elseif ($this->hasRole($roles, $this->roleIds['streamer'])) {
            return 'Streamer';
        } elseif ($this->hasRole($roles, $this->roleIds['external'])) {
            return 'External';
        } elseif ($this->hasRole($roles, $this->roleIds['premium'])) {
            return 'All';
        }
        
        return null;
    }

    /**
     * Check if the user has a specific role.
     *
     * @param array $userRoles
     * @param string $roleId
     * @return bool
     */
    protected function hasRole($userRoles, $roleId)
    {
        return in_array($roleId, $userRoles);
    }

    /**
     * Get the Discord avatar URL.
     *
     * @param array $user
     * @return string|null
     */
    protected function getDiscordAvatar($user)
    {
        if (!isset($user['avatar'])) {
            return null;
        }

        $extension = strpos($user['avatar'], 'a_') === 0 ? 'gif' : 'png';
        return sprintf('https://cdn.discordapp.com/avatars/%s/%s.%s', 
            $user['id'], 
            $user['avatar'],
            $extension
        );
    }
}
