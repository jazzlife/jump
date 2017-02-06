<?php

/*
|--------------------------------------------------------------------------
| API Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of API routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->post('/login', 'Auth\\AuthController@store');
$app->post('/logout', 'Auth\\AuthController@destroy');