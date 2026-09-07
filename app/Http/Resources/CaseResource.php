<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'case_number' => $this->case_number,

            'case_type' => $this->case_type,

            'description' => $this->description,

            'status' => $this->status,

            'start_date' => $this->start_date?->format('Y-m-d'),

            'end_date' => $this->end_date?->format('Y-m-d'),

            'client' => $this->whenLoaded('client', function () {
                return [
                    'id' => $this->client->id,
                    'name' => $this->client->name,
                    'email' => $this->client->email,
                ];
            }),

        
            'lawyer' => $this->whenLoaded('lawyer', function () {
                return [
                    'id' => $this->lawyer->id,
                    'name' => $this->lawyer->name,
                    'email' => $this->lawyer->email,
                ];
            }),

            'documents' => $this->whenLoaded('documents'),

            'messages' => $this->whenLoaded('messages'),

            'appointments' => $this->whenLoaded('appointments'),

            'invoices' => $this->whenLoaded('invoices'),

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}