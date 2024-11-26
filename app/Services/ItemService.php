<?php

namespace App\Services;

use App\Http\Requests\ItemDeleteRequest;
use App\Http\Requests\ItemGetRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\ItemUpdateStatusRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Repositories\TaskRepository;

class ItemService
{
    private ItemRepository $repository;
    private TaskRepository $taskRepository;

    public function __construct(ItemRepository $repository, TaskRepository $taskRepository)
    {
        $this->repository = $repository;
        $this->taskRepository = $taskRepository;
    }

    public function index(ItemGetRequest $request)
    {
        return ItemResource::collection(
            $this->repository->index($request->task_id),
        );
    }

    public function store(ItemRequest $request)
    {
        $taskExist = $this->taskRepository->getById($request['task_id']);

        if (!$taskExist) return null;

        $itemCreated = $this->repository->store($this->convertToCreate($request));

        if (!$itemCreated) return null;

        $resource = new ItemResource($itemCreated);

        return $resource;
    }

    public function update(ItemUpdateRequest $request)
    {
        $itemExist = $this->repository->getById($request->id);

        if (!$itemExist) return false;

        $itemUpdated = $this->repository->update($this->convertToUpdate($request, $itemExist));

        return $itemUpdated;
    }

    public function updateStatus(ItemUpdateStatusRequest $request)
    {
        $itemExist = $this->repository->getById($request->id);

        if (!$itemExist) return false;

        $itemExist->status = $request['status'];

        $itemUpdated = $this->repository->update($itemExist);

        return $itemUpdated;
    }

    public function destroy(ItemDeleteRequest $request)
    {
        $itemExist = $this->repository->getById($request->id);

        if (!$itemExist) return false;

        $itemDeleted = $this->repository->destroy($itemExist);

        return $itemDeleted;
    }

    private function convertToCreate(ItemRequest $request): Item
    {
        $item = new Item([
            'name' => $request->name,
            'status' => $request->status,
            'task_id' => $request->task_id,
        ]);

        return $item;
    }

    private function convertToUpdate(ItemUpdateRequest $request, Item $item): Item
    {
        if ($request->filled('name')) {
            $item->name = $request['name'];
        }

        if ($request->filled('status')) {
            $item->status = $request['status'];
        }

        return $item;
    }
}
