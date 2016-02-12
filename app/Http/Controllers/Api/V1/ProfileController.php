<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use GDGFoz\Todo\User\UserTransformer;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/profile",
     *     description="Informações do seu perfil",
     *     operationId="api.profile.index",
     *     tags={"dashboard"},
     *     @SWG\Response(
     *          response=200,
     *          description="Lista dados do seu perfil",
     *          @SWG\Schema(ref="#/definitions/User"),
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="Erro de requição, faltando token auth",
     *          @SWG\Schema(ref="#/definitions/Error_oAuth")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:tasks"}
     *         }
     *     }
     * )
     *
     */
    public function index()
    {
        $user = User::find(\Authorizer::getResourceOwnerId());
        return \ResponseFractal::respondItem($user, new UserTransformer());
    }

}
