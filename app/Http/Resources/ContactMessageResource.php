<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "name" => $this->name,
            "email" => $this->email,
            "message" => $this->message,
            "read" => ($this->read == 1) ? true : false,
            "receivedAt" => $this->created_at->format('F j, Y')
        ];
    }
}
