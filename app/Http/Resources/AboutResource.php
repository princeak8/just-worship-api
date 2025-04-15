<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\FileResource;

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
            "header" => $this->header,
            "content" => $this->content,
            "pastorTitle" => $this->pastor_title,
            "pastorBio" => $this->pastor_bio,
            "pastorPhoto" => new FileResource($this->pastorPhoto),
            "vision" => $this->vision,
            "visionPhoto" => new FileResource($this->visionPhoto),
            "mission" => $this->mission,
            "missionPhoto" => new FileResource($this->missionPhoto)
        ];
    }
}
