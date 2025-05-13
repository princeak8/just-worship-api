<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\FileResource;
use App\Http\Resources\CountryResource;

class CenterResource extends JsonResource
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
            "location" => $this->location,
            "address" => $this->address,
            "country" => new CountryResource($this->country),
            "photo" => new FileResource($this->photo),
            "longitude" => $this->longitude,
            "latitude" => $this->latitude
        ];
    }
}
