<?php

namespace GDGFoz\Repositories;


use GDGFoz\User;

abstract class BaseRepository
{

    protected $perPage = 15;

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }


    /**
     * Retorna o user logado no OAuth
     * @return User
     */
    public function getUserAuth()
    {
        return User::first();
    }

}