<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskByIdRequest;
use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskMultiStoreRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $service;

    public function __construct(TaskService $service) {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function getById(TaskByIdRequest $request){
        $task = $this->service->getById($request);
        if(!$task) return response(['error' => 'task does not found'], 404);

        return $task->response()->setStatusCode(200);
    }

    public function store(TaskRequest $request){
        $request['status'] = 'ativo';
        $taskCreated = $this->service->store($request);

        if(!$taskCreated) return response(['error'=>'task does not was created'])->setStatusCode(401);

        return $taskCreated->response()->setStatusCode(201);
    }

    public function storeAll(TaskMultiStoreRequest $request){
        $createds = [];
        $user = auth('sanctum')->user();
        foreach($request->all() as $task){
            $task['user_id'] = $user->id;
            $taskCreated = Task::create($task);

            if($taskCreated && isset($task['items']) && is_array($task['items'])) {
                $taskCreated->items()->createMany($task['items']);
            }

            $createds[] = $taskCreated;
        }

        if(count($createds) > 0) {
            return response(['message'=>'tasks created with success'])->setStatusCode(201);
        }

        return response(['error'=>'task does not was created'])->setStatusCode(401);
    }

    public function destroy(TaskDeleteRequest $request){
        $taskDeleted = $this->service->destroy($request);

        if(!$taskDeleted) return response(['error'=>'task does not was deleted'])->setStatusCode(401);

        return response(['message'=>'task deleted with success'])->setStatusCode(200);
    }

    public function update(TaskUpdateRequest $request){
        $taskUpdated = $this->service->update($request);

        if(!$taskUpdated) return response(['error'=>'task does not was updated'])->setStatusCode(403);

        return response(['message'=>'task updated with success'])->setStatusCode(200);
    }

    public function updateStatus(TaskUpdateStatusRequest $request){
        $taskUpdated = $this->service->updateStatus($request);

        if(!$taskUpdated) return response(['error'=>'status task does not was updated'])->setStatusCode(403);

        return response(['message'=>'status task updated with success'])->setStatusCode(200);
    }
}
