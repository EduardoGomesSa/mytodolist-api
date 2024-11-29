<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        return $this->task->orderByRaw("FIELD(status, 'ativo', 'inativo')")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById(int $id)
    {
        $task = $this->task->find($id);

        if (!$task) return null;

        return $task;
    }

    public function store(Task $task)
    {
        $taskCreated = $this->task->create([
            'name' => $task->name,
            'description' => $task->description,
            'start_date' => $task->start_date,
            'end_date' => $task->end_date ? $task->end_date : null,
            'status' => $task->status,
        ]);

        if (!$taskCreated) return null;

        $taskCreated->items()->createMany($task->items);

        return $taskCreated;
    }

    public function update(Task $task)
    {
        $taskUpdated = $task->update();

        if ($taskUpdated > 0) return true;

        return false;
    }

    public function destroy(Task $task)
    {
        $taskDeleted = $task->delete();

        if ($taskDeleted > 0) return true;

        return false;
    }
}
