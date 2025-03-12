<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PanelPasswordController extends Controller
{
    /**
     * Show the panel password verification form.
     */
    public function show()
    {
        return view('panel-password-verify');
    }

    /**
     * Verify the panel password.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'panel_password' => 'required',
        ]);

        // Get the stored panel password hash
        $storedHash = Session::get('panel_password');
        
        // Verify the password
        if (Hash::check($request->panel_password, $storedHash)) {
            // Mark the panel password as verified for this session
            Session::put('panel_password_verified', true);
            
            // Get the intended URL or default to dashboard
            $redirectTo = Session::get('url.intended', route('dashboard'));
            Session::forget('url.intended');
            
            return redirect($redirectTo)
                ->with('status', 'Panel password verified successfully.');
        }
        
        return back()->with('error', 'The panel password is incorrect.');
    }
} 