<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $item;

    public function __construct(Item $item) {
        $this->item = $item;
    }

    public function index(){
        return ItemResource::collection(
            $this->item->all(),
        );
    }
}
