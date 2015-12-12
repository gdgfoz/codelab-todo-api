<?php

/**
 * ROTAS API
 */

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function ($router) {

    #Categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');

    #Profile
    $router->group(['middleware' => 'oauth:read:profile'], function($router) {
        $router->get('profile', 'ProfileController@index');
    });

    #Taks
    $router->group(['middleware' => 'oauth:read:tasks'], function($router) {
        $router->get('tasks', 'TaskController@index');
        $router->get('tasks/category/{id}', 'TaskController@findByCategory');
        $router->get('tasks/{id}', 'TaskController@show');
    });

    #OAuth 2
    $router->get('oauth/dialog', ['as' => 'oauth.authorize.getDialog', 'middleware' => ['auth', 'check-authorization-params'], 'uses' => 'OAuthController@getDialog']);
    $router->post('oauth/dialog', ['as' => 'oauth.authorize.postDialog', 'middleware' => ['auth', 'check-authorization-params'], 'uses' => 'OAuthController@postDialog']);
    $router->post('oauth/access_token', ['as' => 'oauth.authorize.accessToken', 'uses' => 'OAuthController@accessToken']);

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
 *      "read:tasks"    : "Permitir leitura de suas tarefas.",
 *      "read:profile"  : "Informações basica do seu perfil (nome, email)",
 *   }
 * )
 */
