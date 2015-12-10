<?php

namespace GDGFoz\Http\Controllers\Api\V1;


use Authorizer;
use Input;
use GDGFoz\Http\Requests;
use GDGFoz\Http\Controllers\Controller;

class OAuthController extends Controller
{


    public function getDialog()
    {
        // display a form where the user can authorize the client to access it's data
        $authParams = Authorizer::getAuthCodeRequestParams();
        $formParams = array_except($authParams,'client');
        $formParams['client_id'] = $authParams['client']->getId();

        $formParams['scope'] = implode(config('oauth2.scope_delimiter'), array_map(function ($scope) {
            return $scope->getId();
        }, $authParams['scopes']));

        return view('oauth.authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
    }

    public function postDialog()
    {
        $params = Authorizer::getAuthCodeRequestParams();
        $params['user_id'] = \Auth::user()->id;
        $redirectUri = '/';

        // if the user has allowed the client to access its data, redirect back to the client with an auth code
        if (Input::get('approve') !== null) {
            $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
        }

        // if the user has denied the client to access its data, redirect back to the client with an error message
        if (Input::get('deny') !== null) {
            $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
        }

        return \Redirect::to($redirectUri);
    }

    public function accessToken()
    {
        return \Response::json(Authorizer::issueAccessToken());
    }


}
