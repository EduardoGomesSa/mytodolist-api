<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository
{
    private Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function index(int $task_id)
    {
        return $this->item->where('task_id', $task_id)->get();
    }

    public function getById(int $id)
    {
        $item = $this->item->find($id);

        if (!$item) return null;

        return $item;
    }

    public function store(Item $item)
    {
        $itemCreated = $this->item->create([
            'name' => $item->name,
            'status' => $item->status,
            'task_id' => $item->task_id,
        ]);

        if (!$itemCreated) return null;

        return $itemCreated;
    }

    public function update(Item $item)
    {
        $itemUpdated = $item->update();

        if ($itemUpdated > 0) return true;

        return false;
    }

    public function destroy(Item $item)
    {
        $itemDeleted = $item->delete();

        if ($itemDeleted > 0) return true;

        return false;
    }
}
