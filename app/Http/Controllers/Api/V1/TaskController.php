<?php

namespace GDGFoz\Http\Controllers\Api\V1;


use GDGFoz\Repositories\TaskRepository;
use GDGFoz\Transformers\TaskTransformer;
use Illuminate\Http\Request;

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
        $this->taskRepository->setPerPage(15);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = $this->taskRepository->all();
        return \ResponseFractal::respondPaginatedCollection($tasks, new TaskTransformer());
    }

    /**
     * Display tasks from category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findByCategory($id)
    {
        $tasks = $this->taskRepository->findByCategory($id);
        return \ResponseFractal::respondPaginatedCollection($tasks, new TaskTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->find($id);
        return \ResponseFractal::respondItem($task, new TaskTransformer());
    }


}
