<?php

/**
 * ROTAS API
 */

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function ($router) {

    #Categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');
    $router->post('categories', 'CategoryController@store');
    $router->put('categories/{id}', 'CategoryController@update');
    $router->delete('categories/{id}', 'CategoryController@destroy');

    #Taks
    $router->get('tasks', 'TaskController@index');
    $router->get('tasks/{id}', 'TaskController@show');
    $router->get('tasks/category/{id}', 'TaskController@findByCategory');
    $router->post('tasks', 'TaskController@store');
    $router->put('tasks/{id}', 'TaskController@update');
    $router->delete('tasks/{id}', 'TaskController@destroy');

    #Profile
    $router->group(['middleware' => 'oauth:profile_read'], function($router) {
        $router->get('profile', 'ProfileController@index');
    });

    #OAuth 2
    $router->get('oauth/dialog', ['as' => 'oauth.authorize.getDialog', 'middleware' => ['auth', 'check-authorization-params'], 'uses' => 'OAuthController@getDialog']);
    $router->post('oauth/dialog', ['as' => 'oauth.authorize.postDialog', 'middleware' => ['auth', 'check-authorization-params'], 'uses' => 'OAuthController@postDialog']);
    $router->post('oauth/access_token', ['as' => 'oauth.authorize.accessToken', 'uses' => 'OAuthController@accessToken']);

    $router->post('auth/register', 'SingUpController@register');

    #Docs
    $router->get('docs', function(){
        $url = '/swagger/index.html?url=' . URL::to('/swagger/swagger.json');
        return redirect($url);
    });

    $router->get('/', function () {
        return [
            'api' => 'V1',
            'name' => 'GDG Foz do Iguaçu',
            'links' => [
                'documentation' => URL::to('api/v1/docs')
            ]
        ];
    });

});


/*
|--------------------------------------------------------------------------
| Anotations documentation
|--------------------------------------------------------------------------
|
|
|
*/
/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="todo.api.gdgfoz.org",
 *   basePath="/api/v1",
 *   produces={"application/json"},
 *   consumes={"application/json"},
 *   @SWG\Info(
 *     title="GDG Foz - To Do Code Lab Android",
 *     description="",
 *     version="1.0.0",
 *     @SWG\Contact(name="GDG Foz", url="https://github.com/gdgfoz"),
 *   ),
 *   @SWG\Definition(
 *         definition="Error_oAuth",
 *         @SWG\Property(
 *             property="status",
 *             type="string",
 *             enum={"success", "error"}
 *         ),
 *         @SWG\Property(
 *             property="error",
 *             type="array",
 *             description="Informações do erro"
 *         )
 *   )
 * )
 */


/**
 * @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="api_key"
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="api_oauth",
 *   type="oauth2",
 *   in="header",
 *   authorizationUrl="http://todo.api.gdgfoz.org/api/v1/oauth/dialog",
 *   flow="accessCode",
 *   tokenUrl="http://todo.api.gdgfoz.org/api/v1/oauth/access_token",
 *   scopes={
 *      "tasks_read"          : "Permitir leitura de suas tarefas.",
 *      "tasks_write"         : "Permitir criar, atualizar e excluir suas tarefas.",
 *      "categories_read"     : "Permitir leitura de suas categorias.",
 *      "categories_write"    : "Permitir criar, atualizar e excluir suas categorias.",
 *      "profile_read"        : "Informações basica do seu perfil (nome, email)",
 *   }
 * )
 */
