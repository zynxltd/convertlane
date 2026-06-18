<?php

use App\Http\Middleware\AdminAccess;
use App\Http\Middleware\ComplianceAccess;
use App\Http\Middleware\SilenceHoneypotSubmissions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'compliance' => ComplianceAccess::class,
            'admin' => AdminAccess::class,
            'honeypot.contact' => SilenceHoneypotSubmissions::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
