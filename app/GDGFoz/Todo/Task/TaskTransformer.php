<?php

namespace GDGFoz\Todo\Task;


use League\Fractal;

class TaskTransformer extends Fractal\TransformerAbstract
{

    protected $availableIncludes = [
        'category',
        'user'
    ];

    /**
     * @param Task $task
     * @return array
     *
     *  @SWG\Definition(
     *   definition="Task",
     *   required={"categoryId", "name"},
     *   @SWG\Property(
     *             property="categoryId",
     *             type="integer",
     *             format="int32"
     *   ),
     *   @SWG\Property(
     *             property="name",
     *             type="string"
     *   ),
     *   @SWG\Property(
     *             property="description",
     *             type="string"
     *   ),
     *   @SWG\Property(
     *             property="isDone",
     *             type="boolean"
     *   ),
     *   @SWG\Property(
     *             property="finalizedAt",
     *             type="dateTime"
     *   ),
     *   @SWG\Property(
     *             property="createdAt",
     *             type="dateTime"
     *   ),
     *   @SWG\Property(
     *             property="updatedAt",
     *             type="dateTime"
     *   )
     * )
     *
     *  @SWG\Definition(
     *   definition="TaskInclude",
     *   required={},
     *   @SWG\Property(
     *             property="category",
     *             description="Dentro de cada tarefa, Inclui um objeto com sua respectiva categoria",
     *             type="string",
     *   ),
     *   @SWG\Property(
     *             property="user",
     *             description="Dentro de cada tarefa, Inclui um objeto USER da pessoa que criou a tarefa",
     *             type="string"
     *   )
     * )
     *
     */
    public function transform(Task $task)
    {
        return [
            'id'          => (int) $task->id,
            'categoryId'  => (int) $task->category_id,
            'name'        => $task->name,
            'description' => $task->description,
            'isDone'      => boolval($task->status),
            'finalizedAt' => (string) $task->finalized_at,
            'createdAt'   => (string) $task->created_at,
            'updatedAt'   => (string) $task->updated_at,

            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => \URL::to('api/v1/tasks', $task->id) . "?" . \Request::getQueryString(),
                ],
                [
                    'rel' => 'category',
                    'uri' => \URL::to('api/v1/tasks/category', $task->category_id) . "?" . \Request::getQueryString(),
                ]
            ]
        ];
    }

    public function includeCategory(Task $task)
    {
        if($category = $task->category)
            return $this->item($category, new CategoryTransformer());
    }

    public function includeUser(Task $task)
    {
        if($user = $task->user)
            return $this->item($user, new UserTransformer());
    }

}