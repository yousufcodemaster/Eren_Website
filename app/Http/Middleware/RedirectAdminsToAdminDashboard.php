<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminsToAdminDashboard
{
    /**
     * Redirect admins to the admin dashboard when they try to access user routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is logged in and is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Check if the current route is not already an admin route
            if (!$request->routeIs('admin.*')) {
                // Redirect to admin dashboard
                return redirect()->route('admin.dashboard')
                    ->with('info', 'As an administrator, you have been redirected to the admin dashboard.');
            }
        }

        return $next($request);
    }
}
