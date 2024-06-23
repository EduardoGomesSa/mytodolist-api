<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemDeleteRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\ItemUpdateStatusRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\ItemService;

class ItemController extends Controller
{
    private $item;
    private $service;

    public function __construct(Item $item, ItemService $service) {
        $this->item = $item;
        $this->service = $service;
    }

    public function index(){
        return ItemResource::collection(
            $this->item->all(),
        );
    }

    public function store(ItemRequest $request){
        $itemCreated = $this->service->store($request);

        if(!$itemCreated) return response(['error'=>'item does not was created'])->setStatusCode(401);

        return $itemCreated->response()->setStatusCode(201);
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

    public function destroy(ItemDeleteRequest $request){
        $itemExist = $this->item->find($request->id);

        if(!$itemExist) return response(["error"=>"item does not exist"])->setStatusCode(404);

        $itemDeleted = $itemExist->delete();

        if(!$itemDeleted) return response(["error"=>"item does not was deleted"])->setStatusCode(401);

        return response(["message"=>"item deleted with success"])->setStatusCode(200);
    }
}
