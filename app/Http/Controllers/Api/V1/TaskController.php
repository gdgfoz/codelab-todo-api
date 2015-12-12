<?php

namespace GDGFoz\Http\Controllers\Api\V1;


use GDGFoz\Category;
use GDGFoz\Repositories\TaskRepository;
use GDGFoz\Transformers\TaskTransformer;

use GDGFoz\Http\Requests;
use GDGFoz\Http\Controllers\Controller;

class TaskController extends Controller
{

    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->taskRepository->setPerPage(10);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/tasks",
     *     description="Lista todas suas tarefas",
     *     operationId="api.tasks.index",
     *     tags={"dashboard"},
     *     @SWG\Response(
     *          response=200,
     *          description="Lista todas as tarefas do seu perfil",
     *          @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/Task") ),
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="Erro de requição, faltando token auth",
     *          @SWG\Schema(ref="#/definitions/Error_oAuth")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:tasks"}
     *         }
     *     }
     * )
     *
     */
    public function index()
    {
        $tasks = $this->taskRepository->listTaskByUser()->paginate();
        return \ResponseFractal::respondCollection($tasks, new TaskTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * *  @SWG\Get(
     *     path="/tasks/{id}",
     *     description="Exibi detalhe de uma unica tarefa",
     *     operationId="api.tasks.show",
     *     tags={"dashboard"},
     *     @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id da tarefas",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="Detalhe da tarefas",
     *          @SWG\Schema(@SWG\Items(ref="#/definitions/Task") ),
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="Erro de requição, faltando token auth",
     *          @SWG\Schema(ref="#/definitions/Error_oAuth")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:tasks"}
     *         }
     *     }
     * )
     *
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);
        return \ResponseFractal::respondItem($task, new TaskTransformer());
    }

    /**
     * Display tasks from category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *  @SWG\Get(
     *     path="/tasks/category/{category}",
     *     description="Lista todas suas tarefas relacionadas a uma categoria",
     *     operationId="api.tasks.category",
     *     tags={"dashboard"},
     *     @SWG\Parameter(
     *          name="category",
     *          in="path",
     *          description="Id da categoria que deseja visualizar as tarefas",
     *          required=true,
     *          type="integer"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          description="Dentro de cada tarefa, Inclui um objeto do tipo CATEGORY/USER",
     *          required=false,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="Lista todas as tarefas do seu perfil",
     *          @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Task") ),
     *     ),
     *     @SWG\Response(
     *          response=400,
     *          description="Erro de requição, faltando token auth",
     *          @SWG\Schema(ref="#/definitions/Error_oAuth")
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized action.",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Categoria não encontrada.",
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"read:tasks"}
     *         }
     *     }
     * )
     *
     */
    public function findByCategory($id)
    {
        $category = Category::find($id);
        if(is_null($category)) return \ResponseFractal::respondErrorNotFound('Categoria não encontrada');

        $tasks = $this->taskRepository->findByCategory($id)->paginate();
        return \ResponseFractal::respondCollection($tasks, new TaskTransformer());
    }


}
