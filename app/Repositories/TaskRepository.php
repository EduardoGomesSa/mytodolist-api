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

    public function getById(int $id){
        $task = $this->task->find($id);

        if(!$task) return null;

        return $task;
    }
}
