<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'status'=>$this->status,
            'created_at'=>Carbon::parse($this->created_at)->timezone('America/Fortaleza')->toDateTimeString(),
            'updated_at'=>Carbon::parse($this->updated_at)->timezone('America/Fortaleza')->toDateTimeString(),
            'user_id' => $this->user_id,
            'items'=>ItemResource::collection(
                $this->items()
            ->orderByRaw("FIELD(status, 'ativo', 'inativo')")
            ->orderBy('created_at', 'desc')
            ->get()
        ),
        ];
    }
}
