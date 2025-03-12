<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user has set a panel password
        if (!Session::has('panel_password')) {
            // Store the intended URL in the session
            Session::put('url.intended', $request->url());
            
            // Redirect to the settings page with a message
            return redirect()->route('settings')
                ->with('error', 'You need to set a panel password before accessing this area.');
        }

        // Check if the panel password has expired (24 hours)
        $createdAt = Session::get('panel_password_created_at');
        if ($createdAt && now()->diffInHours($createdAt) > 24) {
            // Clear the expired panel password
            Session::forget(['panel_password', 'panel_password_created_at']);
            
            // Store the intended URL in the session
            Session::put('url.intended', $request->url());
            
            return redirect()->route('settings')
                ->with('error', 'Your panel password has expired. Please set a new one.');
        }

        // Check if the user has verified their panel password for this session
        if (!Session::has('panel_password_verified')) {
            // Store the intended URL in the session
            Session::put('url.intended', $request->url());
            
            // Redirect to the panel password verification page
            return redirect()->route('panel.password.verify.show');
        }

        return $next($request);
    }
}
