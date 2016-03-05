<?php

namespace App\Http\Transformers;

class TagTransformer extends Transformer
{
    public function transform($task)
    {
        return [
            'name' => $task['name']
        ];
    }
}