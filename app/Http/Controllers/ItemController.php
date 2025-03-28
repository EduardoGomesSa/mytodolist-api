<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemDeleteRequest;
use App\Http\Requests\ItemGetRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Requests\ItemUpdateStatusRequest;
use App\Services\ItemService;

class ItemController extends Controller
{
    private $service;

    public function __construct(ItemService $service) {
        $this->service = $service;
    }

    public function index(ItemGetRequest $request){
        return $this->service->index($request);
    }

    public function store(ItemRequest $request){
        $request['status'] = 'ativo';
        $itemCreated = $this->service->store($request);

        if(!$itemCreated) return response(['error'=>'item does not was created'])->setStatusCode(401);

        return $itemCreated->response()->setStatusCode(201);
    }

    public function update(ItemUpdateRequest $request){
        $itemUpdated = $this->service->update($request);

        if(!$itemUpdated) return response(["error"=>"item does not was updated"])->setStatusCode(401);

        return response(["message"=>"item updated with success"])->setStatusCode(200);
    }

    public function updateStatus(ItemUpdateStatusRequest $request){
        $itemUpdated = $this->service->updateStatus($request);

        if(!$itemUpdated) return response(["error"=>"item does not updated"])->setStatusCode(401);

        return response(["message"=>"status item updated with success"])->setStatusCode(200);
    }

    public function destroy(ItemDeleteRequest $request){
        $itemDeleted = $this->service->destroy($request);

        if(!$itemDeleted) return response(["error"=>"item does not was deleted"])->setStatusCode(401);

        return response(["message"=>"item deleted with success"])->setStatusCode(200);
    }
}
