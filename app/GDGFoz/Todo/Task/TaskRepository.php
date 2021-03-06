<?php

namespace GDGFoz\Todo\Task;


use GDGFoz\Core\Base\BaseRepository;

class TaskRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return String
     */
    function getClassModel()
    {
        return Task::class;
    }

    /**
     * Lista todas as categorias
     * @return $this
     */
    public function listTaskByUser()
    {
        $this->scopeWithEmbed()->scopefindByUser()->scopeOrderTasks();
        return $this;
    }

    /**
     * Retorna uma categoria
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        $this->scopefindByUser();
        return $this->query->find($id, $columns);
    }

    /**
     * Lista todas as taks de uma categoria
     * @param $categoryId
     */
    public function findByCategory($categoryId)
    {
        $this->scopeWithEmbed()->scopefindByUser()->scopeOrderTasks();
        $this->query->where('category_id', $categoryId);
        return $this;
    }

    public function scopeOrderTasks()
    {
        $this->query->orderBy('status', 'ASC')->orderBy('created_at', 'DESC');
        return $this;
    }

}