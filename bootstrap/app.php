<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__.'/../routes/web.php')
    ->withMiddleware(function (Middleware $middleware) {
        // Prototype mode: this MVP uses config-backed dummy data and does not need
        // encrypted cookies or sessions. Removing these keeps the demo runnable on
        // minimal local PHP installs where openssl/mbstring may not be enabled.
        $middleware->web(remove: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        ]);

        $middleware->alias([
            'auth.zizini' => \App\Http\Middleware\EnsureAuthenticated::class,
            'role' => \App\Http\Middleware\EnsureRole::class,
            'seller' => \App\Http\Middleware\EnsureSeller::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
