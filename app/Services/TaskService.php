<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskService{
    private $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }

    public function store(TaskRequest $request){
        $taskCreated = $this->task->create($request->all());

        if(!$taskCreated) null;
        //if(!$taskCreated) return response(['error'=>'task does not was created'])->setStatusCode(401);

        if($request->items){
            $taskCreated->items()->createMany($request->items);
        }

        $resource = new TaskResource($taskCreated);

        return $resource;
    }
}