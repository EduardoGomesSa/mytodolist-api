<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository{
    private Task $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }

    public function index(){
        return $this->task->all();
    }
}
