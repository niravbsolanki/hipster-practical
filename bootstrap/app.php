<?php

use App\Http\Middleware\IfAdminNotRedirect;
use App\Http\Middleware\IfAdminRedirect;
use App\Http\Middleware\IfCustomerNotRedirect;
use App\Http\Middleware\IfCustomerRedirect;
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
            'admin.guest' => IfAdminRedirect::class, 
            'admin.auth' => IfAdminNotRedirect::class, 
            'customer.guest' => IfCustomerRedirect::class, 
            'customer.auth' => IfCustomerNotRedirect::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
