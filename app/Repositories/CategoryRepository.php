<?php

namespace GDGFoz\Repositories;


use GDGFoz\Category;

class CategoryRepository extends BaseRepository
{

    /**
     * @var Category
     */
    protected $model;

    /**
     * TaskRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Lista todas as categorias
     */
    public function all()
    {
        return $this->model->orderBy('category')->get();
    }

    /**
     * Retorna uma categoria
     * @param $categoryId
     */
    public function find($categoryId)
    {
        return $this->model->find($categoryId);
    }

}