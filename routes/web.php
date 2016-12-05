<?php

/*
|--------------------------------------------------------------------------
| Web Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$pages = [
    '/' => 'index',
    '/error' => 'error',
    '/bad-browser' => 'browser',
];

collect($pages)->each(function ($page, $path) use ($app) {
    $app->get($path, "PageController@{$page}");
});