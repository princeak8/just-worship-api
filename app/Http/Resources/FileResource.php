<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            "url" => url($this->url),
            "mimeType" => $this->mime_type,
            "filename" => $this->filename,
            "extension" => $this->extension,
            "size" => $this->size,
        ];
    }
}
