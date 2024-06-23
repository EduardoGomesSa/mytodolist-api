<?php

namespace App\Services;

use App\Http\Requests\ItemDeleteRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\ItemUpdateStatusRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Repositories\TaskRepository;

class ItemService {
    private Item $item;
    private ItemRepository $repository;
    private TaskRepository $taskRepository;

    public function __construct(Item $item, ItemRepository $repository, TaskRepository $taskRepository) {
        $this->item = $item;
        $this->repository = $repository;
        $this->taskRepository = $taskRepository;
    }

    public function index(){
        return ItemResource::collection(
            $this->repository->index(),
        );
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
        $itemExist = $this->repository->getById($request->id);
        
        if(!$itemExist) return false;

        $itemUpdated = $this->repository->update($this->convertToUpdate($request, $itemExist));
        
        return $itemUpdated;
    }

    public function updateStatus(ItemUpdateStatusRequest $request){
        $itemExist = $this->item->find($request->id);
        
        if(!$itemExist) return false;

        $itemUpdated = $itemExist->update($request->all());

        if($itemUpdated > 0) return true;

        return false;
    }

    public function destroy(ItemDeleteRequest $request){
        $itemExist = $this->repository->getById($request->id);
        
        if(!$itemExist) return false;

        $itemDeleted = $this->repository->destroy($itemExist);

        return $itemDeleted;
    }

    private function convertToUpdate(ItemUpdateRequest $request, Item $item) : Item{
        if($request->filled('name')){
            $item->name = $request['name'];
        }

        if($request->filled('description')){
            $item->description = $request['description'];
        }

        if($request->filled('status')){
            $item->status = $request['status'];
        }

        return $item;
    }
}