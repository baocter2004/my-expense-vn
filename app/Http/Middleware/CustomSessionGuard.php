<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CustomSessionGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $first = $request->segment(1);

        if ($first === 'admin') {
            Config::set('session.cookie', 'admin_session');
            Config::set('session.path', '/admin');
        } else {
            Config::set('session.cookie', 'client_session');
            Config::set('session.path', '/');
        }

        return $next($request);
    }
}
