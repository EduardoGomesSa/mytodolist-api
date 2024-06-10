<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
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
        $taskCreated = $this->task->create($request->all());

        if($taskCreated == null) return response(['error'=>'task does not was created'])->setStatusCode(401);

        if($request->items){
            $taskCreated->items()->createMany($request->items);
        }

        $resource = new TaskResource($taskCreated);

        return $resource->response()->setStatusCode(201);
    }

    public function destroy(TaskDeleteRequest $request){
        $taskExist = $this->task->find($request->id);

        if($taskExist == null) return response(['error'=>'task does not exist'])->setStatusCode(404);

        $taskDestroyed = $taskExist->delete();

        if(!$taskDestroyed) return response(['error'=>'task does not was excluded'])->setStatusCode(401);
        
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
