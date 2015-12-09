<?php

namespace GDGFoz\Transformers;

use GDGFoz\User;
use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = [];

    public function transform(User $user)
    {
        return [
            'id'          => (int) $user->id,
            'name'        => $user->name,
            'created_at'  => (string) $user->created_at
        ];
    }


}