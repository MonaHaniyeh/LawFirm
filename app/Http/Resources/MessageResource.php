<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id,

            'sender' => [
                'id' => $this->sender?->id,
                'name' => $this->sender?->name,
            ],

            'receiver' => [
                'id' => $this->receiver?->id,
                'name' => $this->receiver?->name,
            ],

            'content' => $this->content,
            'is_new' => (bool) $this->is_new,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}