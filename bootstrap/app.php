<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'prevent.admin.registration' => \App\Http\Middleware\PreventAdminRegistration::class,
        ]);
    })
    ->withCommands([
        \App\Console\Commands\ManageAdmin::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();