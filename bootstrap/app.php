<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware — SetLocale runs on every request
        $middleware->web(append: [
            SecurityHeaders::class,
            SetLocale::class,
        ]);

        // Route middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $exception, Request $request) {
            if (
                $exception->getStatusCode() === 419
                && $exception->getPrevious() instanceof TokenMismatchException
                && $request->isMethod('post')
                && $request->is('register')
            ) {
                $locale = $request->session()->get('locale', config('app.locale', 'id'));

                return redirect()->route('register')
                    ->withInput($request->only('name', 'email'))
                    ->with('registration_session_expired', __('auth.session_expired', [], $locale));
            }
        });
    })->create();
