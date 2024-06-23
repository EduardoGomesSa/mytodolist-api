<?php

namespace App\Services;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\TaskRepository;

class ItemService {
    private Item $item;
    private TaskRepository $taskRepository;

    public function __construct(Item $item, TaskRepository $taskRepository) {
        $this->item = $item;
        $this->taskRepository = $taskRepository;
    }

    public function store(ItemRequest $request){
        $taskExist = $this->taskRepository->getById($request['task_id']);

        if(!$taskExist) return null;

        $itemCreated = $this->item->create($request->all());

        if(!$itemCreated) return null;

        $resource = new ItemResource($itemCreated);

        return $resource;
    }

    public function update(ItemUpdateRequest $request){
        $itemExist = $this->item->find($request->id);
        
        if(!$itemExist) return false;

        $itemUpdated = $itemExist->update($request->all());

        if($itemUpdated > 0) return true;

        return false;
    }
}