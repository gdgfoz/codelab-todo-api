<?php

namespace GDGFoz\Core\Contracts;

interface RepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return String
     */
    public function getClassModel();

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    public function all();

}