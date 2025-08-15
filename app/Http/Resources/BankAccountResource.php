<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CountryResource;
use App\Http\Resources\BankResource;

class BankAccountResource extends JsonResource
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
            "type" => $this->type,
            "currency" => $this->currency,
            "bank" => new BankResource($this->bank),
            "name" => $this->name,
            "number" => $this->number,
            "swift_bic" => $this->swift_bic,
            "country" => new CountryResource($this->country)
        ];
    }
}
