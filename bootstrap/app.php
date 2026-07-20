<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\ValidateCmsUploads;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append(\App\Http\Middleware\MaintenanceModeMiddleware::class);
        $middleware->append(\App\Http\Middleware\TrackVisitors::class);
        $middleware->append(SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\PurifyHtmlInput::class);

        $middleware->alias([
            'adminAuth' => AdminAuth::class,
            'ipWhitelist' => \App\Http\Middleware\IpWhitelistMiddleware::class,
            'validateCmsUploads' => ValidateCmsUploads::class,
            'systemTools' => \App\Http\Middleware\SystemToolsGuard::class,

            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
