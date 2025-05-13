<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\VolunteerResource;

class VolunteeringTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            "id" => $this->id,
            "name" => $this->name,
            "task" => $this->task,
            "description" => $this->description,
            "volunteers" => VolunteerResource::collection($this->whenLoaded('volunteers'))
        ];

        $resource['volunteersCount'] = $this->volunteers->count();

        return $resource;
    }
}
