<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;

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

    public function store(ItemRequest $request){
        $itemCreated = $this->item->create($request->all());

        if(!$itemCreated) return response(['error'=>'Item wasn´t created'])->setStatusCode(401);

        $resource = new ItemResource($itemCreated);

        return $resource->response()->setStatusCode(201);
    }
}
