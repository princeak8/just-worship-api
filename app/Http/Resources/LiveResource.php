<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\FileResource;

class LiveResource extends JsonResource
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
            "url" => $this->url,
            "title" => $this->title,
            "date" => $this->live_date,
            "time" => Carbon::createFromFormat('H:i:s', $this->live_time)->format('h:i A'),
            "coverPhoto" => new FileResource($this->coverPhoto),
            "description" => $this->description,
        ];
    }
}
