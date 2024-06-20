<?php

namespace App\Services;

use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService{
    private $task;
    private TaskRepository $repository;

    public function __construct(Task $task, TaskRepository $repository) {
        $this->task = $task;
        $this->repository = $repository;
    }

    public function index(){
        return TaskResource::collection(
            $this->repository->index(),
        );
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

    public function update(TaskUpdateRequest $request){
        $taskExist = $this->repository->getById($request->id);

        if(!$taskExist) return false;

        $taskUpdated = $taskExist->update($request->all());

        if($taskUpdated > 0) return true;

        return false;
    }

    public function updateStatus(TaskUpdateStatusRequest $request){
        $taskExist = $this->repository->getById($request->id);

        if($taskExist == null) return false;

        $taskUpdated = $taskExist->update($request->all());

        if($taskUpdated > 0) return true;

        return false;
    }

    public function destroy(TaskDeleteRequest $request){
        $taskExist = $this->repository->getById($request->id);

        if(!$taskExist) return false;

        $taskDeleted = $taskExist->delete();

        if($taskDeleted > 0) return true;
        
        return false;
    }
}