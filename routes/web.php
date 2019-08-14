<?php

$router->get('/', function () use ($router) {
    echo "Welcome to my app";
});

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth:api'], function () use ($router) {
    // Users Routes
    $router->get('/users', 'UserController@index');
    $router->post('/users', 'UserController@store');
    $router->get('/users/{user}', 'UserController@show');
    $router->put('/users/{user}', 'UserController@update');
    $router->delete('/users/{user}', 'UserController@destroy');
    // Student Routes
    $router->get('/students', 'StudentController@index');
    $router->post('/students', 'StudentController@store');
    $router->get('/students/{student}', 'StudentController@show');
    $router->put('/students/{student}', 'StudentController@update');
    $router->delete('/students/{student}', 'StudentController@destroy');
});

$router->group(['prefix' => 'api/auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});


$router->group(['prefix' => 'api/auth', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('/logout', 'AuthController@logout');
    $router->get('/getuser', 'AuthController@getUser');
});