<?php

/**
 * ROTAS API
 */

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function ($router) {

    #Categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');

    #Taks
    $router->group(['middleware' => 'oauth:read_task'], function($router) {
        $router->get('tasks', 'TaskController@index');
        $router->get('tasks/category/{id}', 'TaskController@findByCategory');
        $router->get('tasks/{id}', 'TaskController@show');
    });

    #oauth
    $router->post('oauth/access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });

    $router->get('/', function () {
        return [
            'api' => 'V1',
            'name' => 'GDG Foz do Iguaçu'
        ];
    });

});

