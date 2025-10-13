<?php

namespace App\Http\Middleware;

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
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on guard type
                return match ($guard) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'user' => redirect()->route('client.index'),
                    default => $this->redirectBasedOnCurrentUser($request)
                };
            }
        }

        return $next($request);
    }

    /**
     * Redirect based on currently authenticated user (if guard not specified)
     */
    protected function redirectBasedOnCurrentUser(Request $request): Response
    {
        // Check if user is authenticated as admin
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Check if user is authenticated as client
        if (Auth::guard('user')->check()) {
            return redirect()->route('client.index');
        }

        // If no guard specified and no user authenticated, continue to next middleware
        return redirect('/');
    }
}

