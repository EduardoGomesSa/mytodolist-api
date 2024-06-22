<?php

namespace App\Services;

use App\Http\Requests\TaskDeleteRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskUpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Item;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return TaskResource::collection(
            $this->repository->index(),
        );
    }

    public function store(TaskRequest $request)
    {
        $taskCreated = $this->repository->store($this->convertToCreate($request));

        if (!$taskCreated) null;

        $resource = new TaskResource($taskCreated);

        return $resource;
    }

    public function update(TaskUpdateRequest $request)
    {
        $taskExist = $this->repository->getById($request->id);

        if (!$taskExist) return false;

        $taskUpdated = $this->repository->update($this->convertToUpdate($request, $taskExist));

        return $taskUpdated;
    }

    public function updateStatus(TaskUpdateStatusRequest $request)
    {
        $taskExist = $this->repository->getById($request->id);

        if (!$taskExist) return false;

        $taskExist->status = $request['status'];

        $taskUpdated = $this->repository->updateStatus($taskExist);

        return $taskUpdated;
    }

    public function destroy(TaskDeleteRequest $request)
    {
        $taskExist = $this->repository->getById($request->id);

        if (!$taskExist) return false;

        $taskDeleted = $this->repository->destroy($taskExist);

        return $taskDeleted;
    }

    private function convertToCreate(TaskRequest $request): Task
    {
        $task = new Task([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'status' => $request->status,
        ]);

        if ($request->filled('end_date')) {
            $task->end_date = $request->end_date;
        }

        if ($request->filled('items')) {
            $items = [];

            foreach ($request->input('items') as $item) {
                $item = new Item([
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'status' => $item['status'],
                ]);

                $items[] = $item->toArray();
            }

            $task->setRelation('items', $items);
        }

        return $task;
    }

    private function convertToUpdate(TaskUpdateRequest $request, Task $task) : Task{
        if($request->filled('name')){
            $task->name = $request['name'];
        }

        if($request->filled('description')){
            $task->description = $request['description'];
        }

        if($request->filled('status')){
            $task->status = $request['status'];
        }

        return $task;
    }
}
