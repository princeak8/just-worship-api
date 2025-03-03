<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
            "vision" => $this->vision,
            "visionPhoto" => $this->vision_photo,
            "mission" => $this->mission,
            "missionPhoto" => $this->mission_photo
        ];
    }
}
