<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$guards
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Get the authenticated user
                $user = Auth::guard($guard)->user();
                
                // Redirect based on user role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                // Redirect resellers to reseller dashboard
                if ($user->is_reseller) {
                    return redirect()->route('reseller.dashboard');
                }
                
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
