<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsResellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_reseller) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Reseller access required.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'You do not have reseller privileges.');
        }

        return $next($request);
    }
}
