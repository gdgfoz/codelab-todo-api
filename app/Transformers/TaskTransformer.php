<?php

namespace GDGFoz\Transformers;


use GDGFoz\Task;
use League\Fractal;

class TaskTransformer extends Fractal\TransformerAbstract
{

    protected $availableIncludes = [
        'category',
        'user'
    ];

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
                    'uri' => \URL::to('api/v1/tasks', $task->id),
                ],
                [
                    'rel' => 'category',
                    'uri' => \URL::to('api/v1/tasks/category', $task->category_id),
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