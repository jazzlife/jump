<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

// Register MongoDB provider here because it has to be loaded before Eloquent.
$app->register(Jenssegers\Mongodb\MongodbServiceProvider::class);

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Bind Configuration Files
|--------------------------------------------------------------------------
|
| Here we will load configuration files of the application.
|
*/

$app->configure('app');
$app->configure('services');
$app->configure('assets');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware(config('app.middleware'));

$app->routeMiddleware(config('app.route_middleware'));

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

collect(config('app.providers'))->each(function ($provider) use ($app) {
    $app->register($provider);
});

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group([
    'prefix' => 'api',
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['throttle:60,1', 'token:strict'],
], function ($app) {
    require __DIR__ . '/../routes/api.php';
});

$app->group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['throttle:120,1', 'token'],
], function ($app) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
