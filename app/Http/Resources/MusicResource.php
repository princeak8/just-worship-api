<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FileResource;

class MusicResource extends JsonResource
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
            "name" => $this->name,
            "artist" => $this->artist,
            "featuring" => $this->featuring,
            "link" => $this->link,
            "coverPhoto" => new FileResource($this->coverPhoto),
            "default" => ($this->default == 1) ? true : false
        ];
    }
}
