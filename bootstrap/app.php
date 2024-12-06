<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLang;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\Adminrole;
use App\Http\Middleware\Userrole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // $middleware->append(SetLang::class);
        $middleware->appendToGroup('SetLang', SetLang::class);
        $middleware->appendToGroup('AdminModule', [SetLang::class, ValidUser::class, Adminrole::class]);
        $middleware->appendToGroup('UserModule', [ValidUser::class, Userrole::class]);
        
        // $middleware->alias([
        //     'IsUserValid' => ValidUser::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
