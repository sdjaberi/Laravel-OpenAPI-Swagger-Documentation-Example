<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\TrimStrings::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        //\App\Http\Middleware\Cors::class,

    ];

    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
            'bindings',
            //\Fruitcake\Cors\HandleCors::class,
            //\App\Http\Middleware\Cors::class,

            //\App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\ForceJsonResponse::class,
            //
        ],
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\AuthGates::class,

            //\Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
        ],
    ];

    protected $routeMiddleware = [

        //'cors'             => \App\Http\Middleware\Cors::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'auth'             => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'bindings'         => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        //'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        'scopes'           => \Laravel\Passport\Http\Middleware\CheckScopes::class,
        'scope'            => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,

        'swfix'            => \App\Http\Middleware\SwaggerFix::class,
        'json.response'    => \App\Http\Middleware\ForceJsonResponse::class,

    ];
}
