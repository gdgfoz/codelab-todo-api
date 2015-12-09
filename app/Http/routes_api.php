<?php

/**
 * ROTAS API
 */

Route::group(['prefix' => 'api/v1'], function ($router) {

    $router->get('categories', 'CategoryController@index');

    $router->get('/', function () {
        return [
            'api' => 'V1',
            'name' => 'GDG Foz do Iguaçu'
        ];
    });

});

