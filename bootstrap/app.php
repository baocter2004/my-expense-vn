<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CustomSessionGuard;
use App\Http\Middleware\EnsureEmailVerified;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/client.php',
            __DIR__ . '/../routes/admin.php',
        ],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => Authenticate::class,
            'ensure' => EnsureEmailVerified::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
        $middleware->prepend(CustomSessionGuard::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            $isAdmin = Auth::guard('admin')->check() || $request->is('admin') || $request->is('admin/*');

            if ($isAdmin) {
                return response()->view('errors.404-admin', [], 404);
            }

            return response()->view('errors.404-client', [], 404);
        });
    })->create();
