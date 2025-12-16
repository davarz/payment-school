<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckSiswaStatus;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware aliases
        $middleware->alias([
            'role' => CheckRole::class,
            'siswa.status' => CheckSiswaStatus::class,
            'security.headers' => SecurityHeaders::class,
        ]);

        // Global middleware (dijalankan untuk semua request)
        $middleware->append(SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle 500 errors
        $exceptions->report(function (Throwable $e) {
            Log::error('Unhandled Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        });

        // Render custom error pages
        $exceptions->render(function (Throwable $e, $request) {
            if ($e instanceof AuthenticationException) {
                return redirect()->route('login')
                    ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
            
            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }
            
            // For development, show detailed error
            if (app()->environment('local', 'development')) {
                return response()->view('errors.debug', [
                    'error' => $e
                ], 500);
            }
            
            // For production, show generic error page
            return response()->view('errors.500', [], 500);
        });
    })->create();   
