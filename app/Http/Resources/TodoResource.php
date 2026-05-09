<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "is_done"=> $this->is_done,
            "completed_at"=> $this->completed_at?->toDateTimeString(),
            "created_at"=> $this->created_at->toDateTimeString(),
            "priority"=> $this->priority ?? null,
            "due_date"=> $this->due_date ? $this->due_date->toDateTimeString() : null,
        ];
    }
}
