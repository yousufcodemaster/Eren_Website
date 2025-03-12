<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        Laravel\Socialite\SocialiteServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom middleware here
        $middleware->alias([
            'isAdmin' => App\Http\Middleware\IsAdmin::class,    // Admin Middleware
            'isPremium' => App\Http\Middleware\IsPremium::class,  // Premium User Middleware
            'isNormal' => App\Http\Middleware\IsNormal::class,   // Normal User Middleware
            'admin' => App\Http\Middleware\AdminMiddleware::class, // New Admin Middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
