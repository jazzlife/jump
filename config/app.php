<?php

return [

    /**
     * Application Encryption Configuration.
     */

    'key' => env('APP_KEY', ''),

    'cipher' => 'AES-256-CBC',

    /**
     * Application Locale Configuration.
     */

    'locale' => env('APP_LOCALE', 'en'),

    'locales' => env('APP_LOCALES', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /**
     * Application Providers Configuration.
     */

    'providers' => [
        App\Providers\AppServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Vluzrmos\Tinker\TinkerServiceProvider::class,
        Sentry\SentryLaravel\SentryLumenServiceProvider::class,
    ],

    /**
     * Application Middleware Configuration.
     */

    'middleware' => [
        App\Http\Middleware\Localize::class,
    ],

    'route_middleware' => [
        'token' => App\Http\Middleware\ValidateRequestToken::class,
        'throttle' => App\Http\Middleware\ThrottleRequests::class,
    ],

];
