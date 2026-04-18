<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return (new \Illuminate\Pipeline\Pipeline(app()))
                ->send($request)
                ->through([
                    \Illuminate\Session\Middleware\StartSession::class,
                    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                ])
                ->then(function ($request) {
                return response()->view('errors.404', [], 404);
            });
        });
    })->create();
