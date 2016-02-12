<?php
/**
 * Created by PhpStorm.
 * User: valmir
 * Date: 23/01/16
 * Time: 00:51
 */


namespace GDGFoz\Todo\User;

use App\User;

class RegistersUsers
{

    protected $errors;

    protected $user;

    /**
     * @return array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ];

    /**
     * Handle a registration request for the application.
     *
     * @return User
     */
    public function register(array $data)
    {
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        $this->user = $this->create($data);

        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, static::$rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}