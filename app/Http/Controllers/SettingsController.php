<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Update the user's email.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'current_password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return redirect()->route('settings')->with('status', 'Email updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('settings')->with('status', 'Password updated successfully!');
    }

    /**
     * Update the user's panel password.
     * This uses a session-based approach instead of storing in the database.
     */
    public function updatePanelPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'panel_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Store the hashed panel password in the session
        Session::put('panel_password', Hash::make($request->panel_password));
        
        // Store the panel password creation time
        Session::put('panel_password_created_at', now());

        return redirect()->route('settings')->with('status', 'Panel password updated successfully! This password will be valid for your current session.');
    }
} 