<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        if( \Input::has('reset') ) \Session::forget('token');

        $token = \Session::get('token');

        $params = [
            'username'          => \Auth::user()->email,
            'password'          => null,
            'app_name'          => \Config::get('gdgfoz.codelab1.name'),
            'client_id'         => \Config::get('gdgfoz.codelab1.api_id'),
            'client_secret'     => \Config::get('gdgfoz.codelab1.api_secret'),
            'grant_type'        => 'password',
            'scope'             => implode(',' , \Config::get('gdgfoz.codelab1.api_scopes')),
        ];

        return view('dashboard.home')->with('token', $token)->with('params', $params);
    }

    public function generateToken()
    {
        try{

            $result = \Authorizer::issueAccessToken();

            \Session::set('token', array_get($result, 'access_token'));
            return redirect()->back();

        } catch (OAuthException $e) {

            return redirect()->with('error', $e->getMessage());
        }

    }
}