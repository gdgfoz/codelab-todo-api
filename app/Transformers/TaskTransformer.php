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
            'name'        => $task->name,
            'description' => $task->description,
            'status'      => boolval($task->status),
            'created_at'  => (string) $task->created_at
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