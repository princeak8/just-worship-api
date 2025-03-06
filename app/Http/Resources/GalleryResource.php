<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EventResource;
use App\Http\Resources\FileResource;

class GalleryResource extends JsonResource
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
            "photo" => new FileResource($this->photo),
            "title" => $this->title,
            "event" => new EventResource($this->event)
        ];
    }
}
