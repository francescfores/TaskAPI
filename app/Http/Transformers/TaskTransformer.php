<?php

namespace App\Http\Transformers;

 class TaskTransformer extends Transformer
{
    public function transform($task)
    {
        return [
            'name' => $task['name'],
            'done' => (boolean) $task['done'],
            'priority' => (int) $task['priority']
        ];
    }
}
