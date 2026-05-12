<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureRole;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->trustProxies(headers: [
            Request::HEADER_FORWARDED,
            Request::HEADER_X_FORWARDED_FOR,
            Request::HEADER_X_FORWARDED_HOST,
            Request::HEADER_X_FORWARDED_PORT,
            Request::HEADER_X_FORWARDED_PROTO,
            Request::HEADER_X_FORWARDED_AWS_ELB,
        ]);

        $middleware->alias([
            'role' => EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
