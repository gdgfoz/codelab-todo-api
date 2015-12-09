<?php

namespace GDGFoz\Transformers;


use League\Fractal;

class TaskTransformer extends Fractal\TransformerAbstract
{

    public function transform(Task $task)
    {
        return [
            'id'          => (int) $task->id,
            'name'        => $task->name,
            'description' => $task->description,
            'status'      => boolval($task->status),
        ];
    }

}