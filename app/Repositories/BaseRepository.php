<?php

namespace GDGFoz\Repositories;


use GDGFoz\User;

abstract class BaseRepository
{

    protected $porPage = 15;

    /**
     * @return int
     */
    public function getPorPage()
    {
        return $this->porPage;
    }

    /**
     * @param int $porPage
     */
    public function setPorPage($porPage)
    {
        $this->porPage = $porPage;
    }


    /**
     * Retorna o user logado no OAuth
     * @return User
     */
    public function getUserAuth()
    {

    }

}