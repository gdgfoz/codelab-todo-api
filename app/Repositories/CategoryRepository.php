<?php

namespace GDGFoz\Repositories;


use GDGFoz\Category;

class CategoryRepository extends BaseRepository
{


    /**
     * Specify Model class name
     *
     * @return String
     */
    function getClassModel()
    {
        return Category::class;
    }

    /**
     * Lista todas as categorias
     */
    public function listCategories()
    {
        $this->query->orderBy('category');
        return $this;
    }


}