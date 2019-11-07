<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
  // Game routes
  $router->post('game', 'GameController@new');
  $router->get('game/{id}', 'GameController@get');
  $router->post('game/{id}', 'GameController@play');
  $router->put('game/{id}', 'GameController@flag');
  // User routes
  $router->post('user', 'UserController@login');
  $router->put('user/{id}', 'UserController@update');
});
