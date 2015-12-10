<?php

namespace GDGFoz\Repositories;


use GDGFoz\User;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository implements BaseRepositoryInterface
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * Items per page
     * @var int
     */
    protected $perPage = 15;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * @param App $app
     */
    public function __construct(App $app) {
        $this->makeModel($app);
    }

    /**
     * Specify Model class name
     *
     * @return String
     */
    abstract function getClassModel();

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->query->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->query->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function findOrFail($id){
        return $this->query->findOrFail($id);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')) {
        return $this->query->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = null, $columns = array('*')) {
        $perPage = ( is_null($perPage) )? $this->perPage : $perPage;
        return $this->query->paginate($perPage, $columns);
    }

    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function orderBy($column, $order = "ASC"){
        $this->query->orderBy($column, $order);
        return $this;
    }

    public function debug()
    {
        dd($this->query->toSql());
    }

    /**
     * Retorna o user logado no OAuth
     * @return User
     */
    protected function getAuthUserId()
    {

        $userId = \Authorizer::getResourceOwnerId();

        if(is_null($userId)){
            throw new \Exception('User not logged in!');
        }

        return $userId;
    }


    /**
     * Otimiza as query do Eloquent adicionando
     * Eager Loading do Eloquent
     * @param string cidade,cidade.estado
     * @return \Eloquent
     */
    protected function scopeWithEmbed($embed = null){

        $embed = (is_null($embed))? \Input::get('include') : $embed;
        $requestedEmbeds = explode(',', $embed);
        $possibleRelationships = (array) $this->model->relationships;

        $eagerLoad = array_values(
            array_intersect( $possibleRelationships, $requestedEmbeds)
        );

        if( ! empty($eagerLoad) ) {
            \Log::info($eagerLoad);
            $this->query->with( $eagerLoad );
        }


        return $this;
    }

    /**
     * Filtra garante que apenas Tasks do usuários seja filtradas
     * @return $this
     */
    protected function scopefindByUser()
    {
        $this->query->where('user_id', $this->getAuthUserId());
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        return $this->query = $this->model->newQuery();
    }

    /**
     * @param App $app
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function makeModel($app) {
        $this->model = $app->make($this->getClassModel());

        if (!$this->model instanceof Model)
            throw new \Exception("Class {$this->getClassModel()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        $this->newQuery();
    }

}