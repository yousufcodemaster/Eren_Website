<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SetDiscordUsernameController extends Controller
{
    /**
     * Show the form for setting Discord username.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.set-discord-username');
    }

    /**
     * Handle the incoming request to set Discord username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'discord_username' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->discord_username = $request->discord_username;
        $user->save();

        return redirect()->intended(route('dashboard'));
    }
}
