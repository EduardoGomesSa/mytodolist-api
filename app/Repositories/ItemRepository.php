<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository {
    private Item $item;

    public function __construct(Item $item) {
        $this->item = $item;
    }

    public function index(){
        return $this->item->all();
    }
}