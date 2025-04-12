<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// ... other routes ...

$router->get('/protected-resource', [
    'middleware' => 'auth.access',
    'uses' => 'YourController@yourMethod'
]);

$router->post('/secure-endpoint', [
    'middleware' => 'auth.access',
    'uses' => 'AnotherController@anotherMethod'
]);

// ... other routes ...
// Group all API routes under 'api' prefix and apply JWT middleware
$router->group(['prefix' => 'api', 'middleware' => 'auth:api'], function () use ($router) {

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