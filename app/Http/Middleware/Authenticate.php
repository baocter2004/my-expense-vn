<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

class Authenticate extends MiddlewareAuthenticate
{
    protected array $guards = [];

    protected function authenticate($request, array $guards)
    {
        $this->guards = $guards;

        parent::authenticate($request, $guards);
    }
    /**
     * Handle redirect if user/admin is not logged in.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            throw new AuthenticationException();
        }

        $guard = $this->guards[0] ?? 'user';

        return match ($guard) {
            'admin' => route('auth.admin.login'),
            default => route('auth.client.login'),
        };
    }
}
