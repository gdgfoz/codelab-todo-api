<?php

namespace App\Http\Controllers\Api\V1;


use GDGFoz\Todo\Category\Category;
use GDGFoz\Todo\Category\CategoryRepository;
use GDGFoz\Todo\Task\TaskRepository;
use GDGFoz\Todo\Task\TaskRequest;
use GDGFoz\Todo\Task\TaskTransformer;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param TaskRepository $taskRepository
     * @internal param CategoryRepository $categoryRepository
     */
    public function __construct(TaskRepository $taskRepository, CategoryRepository $categoryRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->taskRepository->setPerPage(10);

        $this->categoryRepository = $categoryRepository;

        $this->middleware('oauth:tasks_read',  ['only' => ['index', 'show', 'findByCategory']]);
        $this->middleware('oauth:tasks_write', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/tasks",
     *     description="Lista todas suas tarefas",
     *     @SWG\Response(
     *          response=200,
     *          description="Lista todas as tarefas do seu perfil",
     *          @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/Task") ),
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"oauth:tasks_read"}
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
     *     security={
     *         {
     *             "api_oauth": {"oauth:tasks_read"}
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

    public function store(TaskRequest $requests)
    {
        $task = $requests->save();
        return \ResponseFractal::respondCreateItemSucess($task, new TaskTransformer());
    }

    public function update(TaskRequest $requests, $taskId)
    {
        $task = $this->taskRepository->find($taskId);
        $task = $requests->update($task);
        return \ResponseFractal::respondUpdateItemSucess($task, new TaskTransformer());
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
     *     @SWG\Response(
     *          response=200,
     *          description="Lista todas as tarefas do seu perfil",
     *          @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Task") ),
     *     ),
     *     security={
     *         {
     *             "api_oauth": {"oauth:tasks_read"}
     *         }
     *     }
     * )
     *
     */
    public function findByCategory($id)
    {
        $category = $this->categoryRepository->find($id);
        if(is_null($category)) return \ResponseFractal::respondErrorNotFound('Categoria não encontrada');

        $tasks = $this->taskRepository->findByCategory($id)->paginate();
        return \ResponseFractal::respondCollection($tasks, new TaskTransformer());
    }


}
