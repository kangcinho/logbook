<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'admin' => \App\Http\Middleware\Admin::class,
        'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,
        'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'menu_logbook' => \App\Http\Middleware\LogbookMiddleware::class,
        'menu_upadana' => \App\Http\Middleware\UpadanaMiddleware::class,
        'menu_babyspa' => \App\Http\Middleware\BabySPAMiddleware::class,
        'menu_kliniklaktasi' => \App\Http\Middleware\KlinikLaktasiMiddleware::class,
        'menu_radiologi' => \App\Http\Middleware\RadiologiMiddleware::class,
        'menu_echocardiography' => \App\Http\Middleware\EchocardiographyMiddleware::class,
        'menu_master' => \App\Http\Middleware\MasterMiddleware::class,
        'menu_penomoran' => \App\Http\Middleware\PenomoranMiddleware::class,
    ];
}
