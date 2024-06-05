<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }

    public function index(){
        return TaskResource::collection(
            $this->task->all(),
        );
    }

    public function store(TaskRequest $request){
        $task = $this->task->create($request->all());

        if($task == null) return response(['error'=>'task wasn´t created'])->setStatusCode(401);

        $resource = new TaskResource($task);

        return $resource->response()->setStatusCode(201);
    }
}
