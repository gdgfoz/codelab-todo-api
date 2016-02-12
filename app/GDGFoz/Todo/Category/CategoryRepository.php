<?php

namespace GDGFoz\Todo\Category;


use GDGFoz\Core\Base\BaseRepository;

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

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = array('*'))
    {
        $this->scopefindByUser();
        return $this->query->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Category
     */
    public function find($id, $columns = array('*'))
    {
        $this->scopefindByUser();
        return $this->query->find($id, $columns);
    }

    protected function scopefindByUser()
    {
        $this->query->select('categories.*')
                    ->join('categories_users', 'categories_users.category_id', '=', 'categories.id')
                    ->where('categories_users.user_id', $this->getAuthUserId());

        return $this;
    }
}