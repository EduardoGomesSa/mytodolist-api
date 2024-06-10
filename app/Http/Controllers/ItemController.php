<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\ItemUpdateStatusRequest;
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

        if(!$itemCreated) return response(['error'=>'item does not was created'])->setStatusCode(401);

        $resource = new ItemResource($itemCreated);

        return $resource->response()->setStatusCode(201);
    }

    public function update(ItemUpdateRequest $request){
        $itemExist = $this->item->find($request->id);

        if(!$itemExist) return response(['error'=>'item does not exist'])->setStatusCode(404);

        $itemUpdated = $itemExist->update($request->all());

        if(!$itemUpdated) return response(["error"=>"item does not was updated"])->setStatusCode(401);

        return response(["message"=>"item updated with success"])->setStatusCode(200);
    }

    public function updateStatus(ItemUpdateStatusRequest $request){
        $itemExist = $this->item->find($request->id);

        if(!$itemExist) return response(["error"=>"item does not exist"])->setStatusCode(404);

        $itemUpdated = $itemExist->update($request->all());

        if(!$itemUpdated) return response(["error"=>"item does not updated"])->setStatusCode(401);

        return response(["message"=>"status item updated with success"])->setStatusCode(200);
    }
}
