<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\DiscipleshipMemberResource;
use App\Http\Resources\FileResource;
use App\Http\Resources\CountryResource;

class DiscipleshipResource extends JsonResource
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
            "month" => $this->month,
            "monthName" => date("F", mktime(0, 0, 0, $this->month, 1)),
            "year" => $this->year,
            "open" => $this->open,
            "deadline" => $this->deadline,
            "venue" => $this->venue,
            "online" => ($this->online == 1) ? true : false,
            "link" => $this->link,
            "photo" => new FileResource($this->whenLoaded("photo")),
            "country" => new CountryResource($this->country),
            "members" => DiscipleshipMemberResource::collection($this->whenLoaded('members'))
        ];
    }
}
