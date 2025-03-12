<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DiscordAuthController extends Controller
{
    public function redirect()
    {
        $state = Str::random(40);
        session(['discord_state' => $state]);

        $query = http_build_query([
            'client_id' => config('services.discord.client_id'),
            'redirect_uri' => config('services.discord.redirect'),
            'response_type' => 'code',
            'scope' => 'identify email',
            'state' => $state,
        ]);

        return redirect('https://discord.com/api/oauth2/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        if ($request->get('state') !== session('discord_state')) {
            return redirect()->route('login')->with('error', 'Invalid state parameter.');
        }

        $token = $this->getAccessToken($request->get('code'));
        if (!$token) {
            return redirect()->route('login')->with('error', 'Failed to get access token.');
        }

        $discordUser = $this->getDiscordUser($token);
        if (!$discordUser) {
            return redirect()->route('login')->with('error', 'Failed to get user information.');
        }

        $user = User::updateOrCreate(
            ['discord_id' => $discordUser['id']],
            [
                'name' => $discordUser['username'],
                'email' => $discordUser['email'],
                'discord_avatar' => $this->getDiscordAvatar($discordUser),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

    protected function getAccessToken($code)
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

        return $response->json()['access_token'];
    }

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