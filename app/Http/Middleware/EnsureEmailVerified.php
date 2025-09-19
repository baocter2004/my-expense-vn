<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $exceptRoutes = [
            'client.profile',
            'client.update-info',
            'client.update-password',
            'client.update-avatar',
        ];
        if ($request->user() && ! $request->user()->hasVerifiedEmail()) {
            if (! in_array($request->route()->getName(), $exceptRoutes)) {
                return redirect()->route('auth.client.verification.notice');
            }
        }

        return $next($request);
    }
}
