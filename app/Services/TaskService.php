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
    private $task;
    private TaskRepository $repository;

    public function __construct(Task $task, TaskRepository $repository)
    {
        $this->task = $task;
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

        $taskUpdated = $taskExist->update($request->all());

        if ($taskUpdated > 0) return true;

        return false;
    }

    public function updateStatus(TaskUpdateStatusRequest $request)
    {
        $taskExist = $this->repository->getById($request->id);

        if ($taskExist == null) return false;

        $taskUpdated = $taskExist->update($request->all());

        if ($taskUpdated > 0) return true;

        return false;
    }

    public function destroy(TaskDeleteRequest $request)
    {
        $taskExist = $this->repository->getById($request->id);

        if (!$taskExist) return false;

        $taskDeleted = $taskExist->delete();

        if ($taskDeleted > 0) return true;

        return false;
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
}
