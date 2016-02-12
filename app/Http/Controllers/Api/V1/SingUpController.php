<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use GDGFoz\Todo\User\RegistersUsers;
use GDGFoz\Todo\User\UserTransformer;
use Illuminate\Http\Request;

class SingUpController extends Controller
{

    /**
     * @var RegistersUsers
     */
    protected $registersUsers;

    /**
     * SingUpController constructor.
     * @param RegistersUsers $registersUsers
     */
    public function __construct(RegistersUsers $registersUsers)
    {
        $this->registersUsers = $registersUsers;
        $this->middleware('guest');
    }


    public function register(Request  $request)
    {
        $user = $this->registersUsers->register($request->all());

        if(!$user) return \ResponseFractal::respondErrorWrongArgs( $this->registersUsers->getErrors() );

        return \ResponseFractal::respondCreateItemSucess($user, new UserTransformer());
    }


}
