<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function index()
    {
        $user = auth('sanctum')->user();

        return $this->task
            ->where('user_id', $user->id)
            ->orderByRaw("FIELD(status, 'ativo', 'inativo')")
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
        $user = auth('sanctum')->user();

        $taskCreated = $this->task->create([
            'name' => $task->name,
            'description' => $task->description,
            'start_date' => $task->start_date,
            'end_date' => $task->end_date ? $task->end_date : null,
            'status' => $task->status,
            'user_id' => $user->id,
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
