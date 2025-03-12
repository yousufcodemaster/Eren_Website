<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class DiscordAuthController extends Controller
{
    /**
     * Redirect the user to the Discord authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('discord')->redirect();
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
            $discordUser = Socialite::driver('discord')->user();
            
            // Check if user exists
            $user = User::where('discord_id', $discordUser->id)->first();
            
            if ($user) {
                // Login existing user
                Auth::login($user);
                return redirect()->intended(route('dashboard'));
            } else {
                // Create new user
                $user = User::create([
                    'name' => $discordUser->name ?? $discordUser->nickname ?? 'Discord User',
                    'email' => $discordUser->email,
                    'password' => bcrypt(Str::random(16)),
                    'discord_id' => $discordUser->id,
                    'discord_avatar' => $discordUser->avatar,
                    'role' => 'normal',
                ]);
                
                Auth::login($user);
                
                // Redirect to set Discord username if needed
                if (empty($user->discord_username)) {
                    return redirect()->route('discord.username.show');
                }
                
                return redirect()->intended(route('dashboard'));
            }
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Discord authentication failed: ' . $e->getMessage());
        }
    }
}
