<?php

/**
 * ROTAS API
 */

Route::group(['prefix' => 'api/v1'], function ($router) {

    #Categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');

    #Taks
    $router->get('tasks', 'TaskController@index');
    $router->get('tasks/category/{id}', 'TaskController@findByCategory');
    $router->get('tasks/{id}', 'TaskController@show');

    $router->get('/', function () {
        return [
            'api' => 'V1',
            'name' => 'GDG Foz do Iguaçu'
        ];
    });

});

