<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// ... other routes ...

$router->group(['prefix' => 'api'], function () use ($router) {
    // Authentication Routes (These should be accessible without a token)
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('user-profile', 'AuthController@me'); // Typically needs a token to get the authenticated user

    // Protected API Routes (Require JWT authentication)
    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        // User Routes
        $router->get('/users', 'UserController@index');
        $router->post('/users', 'UserController@add');
        $router->get('/users/{id}', 'UserController@show');
        $router->put('/users/{id}', 'UserController@update');
        $router->patch('/users/{id}', 'UserController@update');
        $router->delete('/users/{id}', 'UserController@delete');

        // UserJob Routes (Ensure Naming Consistency)
        $router->get('/userjobs', 'UserJobController@index'); // Plural for collection
        $router->get('/userjobs/{id}', 'UserJobController@show'); // Plural for single item retrieval
    });
});