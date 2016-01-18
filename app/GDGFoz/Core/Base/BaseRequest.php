<?php

namespace GDGFoz\Core\Base;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

abstract class BaseRequest extends FormRequest
{

    protected $auth_user;

    /**
     * Retorna o user logado no OAuth
     * @return int
     * @throws \Exception
     */
    protected function getAuthUserId()
    {
        $userId = \Authorizer::getResourceOwnerId();

        if( is_null($userId) ){
            $this->failedAuthorization();
        }

        return $userId;
    }

    protected function getAuthUser()
    {
        if( is_null($this->auth_user) ) {

            if(\Auth::check()) {
                $this->auth_user = \Auth::user();
            }else{
                $userId = $this->getAuthUserId();
                $this->auth_user = User::find($userId);
            }

        }

        return $this->auth_user;
    }



    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        return \ResponseFractal::respondErrorForbidden();
    }

    /**
     * Get the response for a error validate.
     *
     * @param Validator $validator
     * @return \Illuminate\Http\Response
     */
    public function failedValidationResponse(Validator $validator)
    {
        if ( $this->is('api/*') ) {
            return \ResponseFractal::respondErrorWrongArgs($validator->errors());
        }

        return $this->response(
            $this->formatErrors($validator)
        );
    }

    public function internalErrorResponse()
    {
        if ( $this->is('api/*') ) {
            return \ResponseFractal::respondErrorInternalError();
        }

        return $this->response();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return mixed|void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException( $this->failedValidationResponse($validator) );
    }

    /**
     * Handle a failed save.
     *
     * @throws HttpResponseException
     */
    protected function failedSaveModel()
    {
        throw new HttpResponseException( $this->internalErrorResponse() );
    }

    /**
     * Handle a failed update.
     *
     * @throws HttpResponseException
     */
    protected function failedUpdateModel()
    {
        throw new HttpResponseException( $this->internalErrorResponse() );
    }

    /**
     * @param array $errors
     */
    protected function failedCustomValidate(array $errors)
    {
        $response = \ResponseFractal::respondErrorWrongArgs($errors);
        throw new HttpResponseException( $response );
    }

}
