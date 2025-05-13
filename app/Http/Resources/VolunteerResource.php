<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CountryResource;
use App\Http\Resources\VolunteeringTeamResource;

class VolunteerResource extends JsonResource
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
            "email" => $this->email,
            "phoneNumber" => $this->phone_number,
            "country" => new CountryResource($this->country),
            "city" => $this->city,
            "teams" => VolunteeringTeamResource::collection($this->whenLoaded("teams"))
        ];
    }
}
