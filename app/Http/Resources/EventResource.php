<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\EventBookingResource;

use App\Http\Resources\FileResource;

class EventResource extends JsonResource
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
            "featured" => ($this->featured == 1) ? true : false,
            "date" => $this->event_date,
            "time" => ($this->event_time) ? Carbon::createFromFormat('H:i:s', $this->event_time)->format('h:i A') : null,
            "location" => $this->location,
            "coverPhoto" => new FileResource($this->coverPhoto),
            "content" => $this->content,
            "bookings" => EventBookingResource::collection($this->bookings)
        ];
    }
}
