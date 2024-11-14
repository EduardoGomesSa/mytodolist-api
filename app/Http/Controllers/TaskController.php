<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    private $service;

    public function __construct(TaskService $service) {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function store(TaskRequest $request){
        $request['status'] = 'ativo';
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
