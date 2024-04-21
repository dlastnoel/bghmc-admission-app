<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {

            $errors = [
                404 => [
                    'code' => 404,
                    'title' => 'Not Found',
                    'message' => "Looks like we headed off the tracks. We can't take you there but we can get you home."
                ],
                500 => [
                    'code' => 500,
                    'title' => 'Internal Server Error',
                    'message' => "Our server encountered some technical difficulties. We'll be back soon!"
                ],
                503 => [
                    'code' => 503,
                    'title' => 'Service Unavailable',
                    'message' => "Our server is currently undergoing brain surgery. Please come back later."
                ],
            ];

            if (!app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {

                return Inertia::render('Errors/App', ['error' => $errors[$response->getStatusCode()]])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            return $response;
        });
    })->create();
