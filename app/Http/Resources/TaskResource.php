<?php

namespace App\Http\Resources;

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
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
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
