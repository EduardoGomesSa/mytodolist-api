<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $task;
    private $service;

    public function __construct(Task $task, TaskService $service) {
        $this->task = $task;
        $this->service = $service;
    }

    public function index(){
        return TaskResource::collection(
            $this->task->all(),
        );
    }

    public function store(TaskRequest $request){
        $taskCreated = $this->service->store($request);

        if(!$taskCreated) return response(['error'=>'task does not was created'])->setStatusCode(401);

        return $taskCreated->response()->setStatusCode(201);
    }

    public function destroy(TaskDeleteRequest $request){
        $taskDeleted = $this->service->destroy($request);

        if(!$taskDeleted) return response(['error'=>'task does not was deleted'])->setStatusCode(401);
        
        return response(['message'=>'task deleted with success'])->setStatusCode(200);
    }

    public function update(TaskUpdateRequest $request){
        $taskExist = $this->task->find($request->id);

        if($taskExist == null) return response(['error'=>'task does not exist'])->setStatusCode(404);

        $taskUpdated = $taskExist->update($request->all());

        if(!$taskUpdated) return response(['error'=>'task does not was updated'])->setStatusCode(401);

        return response(['message'=>'tast updated with success'])->setStatusCode(200);
    }

    public function updateStatus(TaskUpdateStatusRequest $request){
        $taskExist = $this->task->find($request->id);

        if($taskExist == null) return response(['error'=>'status task does not exist'])->setStatusCode(404);

        $taskUpdated = $taskExist->update($request->all());

        if(!$taskUpdated) return response(['error'=>'status task does not was updated'])->setStatusCode(401);

        return response(['message'=>'status task updated with success'])->setStatusCode(200);
    }
}
