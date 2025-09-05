<?php

use App\Http\Middleware\EmailVerify;
use App\Http\Middleware\LoginMiddleware;
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
        $middleware->appendToGroup('emailVerify' , [
            EmailVerify::class,
//            LoginMiddleware::class,
        ]);
        $middleware->alias([
           'auth' => LoginMiddleware::class
        ]);
//        $middleware->append(EmailVerify::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
