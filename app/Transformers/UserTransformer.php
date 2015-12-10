<?php

namespace GDGFoz\Transformers;

use GDGFoz\User;
use League\Fractal;

class UserTransformer extends Fractal\TransformerAbstract
{

    protected $defaultIncludes = [];

    /**
     *
     * @param User $user
     * @return array
     *
     *  @SWG\Definition(
     *   definition="User",
     *   required={"name"},
     *   @SWG\Property(
     *             property="id",
     *             type="integer",
     *             format="int32"
     *   ),
     *   @SWG\Property(
     *             property="name",
     *             description="Seu nome de usuario",
     *             type="string"
     *   ),
     *   @SWG\Property(
     *             property="createdAt",
     *             description="Data de criacao",
     *             type="datetime"
     *   )
     * )
     */
    public function transform(User $user)
    {
        return [
            'id'          => (int) $user->id,
            'name'        => $user->name,
            'created_at'  => (string) $user->created_at
        ];
    }


}