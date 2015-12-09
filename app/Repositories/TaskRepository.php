<?php

namespace GDGFoz\Repositories;


class TaskRepository extends BaseRepository
{

    /**
     * @var Task
     */
    protected $model;

    /**
     * TaskRepository constructor.
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Lista todas as categorias
     */
    public function all()
    {
        //paginar
    }

    /**
     * Retorna uma categoria
     * @param $categoryId
     */
    public function find($taskId)
    {
    }

    /**
     * Lista todas as taks de uma categoria
     * @param $categoryId
     */
    public function findByCategory($categoryId)
    {
        return $this->model->where('user_id', $this->getUserAuth()->id)->where('category_id', $categoryId)->paginate($this->porPage);
    }

}