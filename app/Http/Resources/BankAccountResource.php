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
            "currency" => $this->currency,
            "bank" => new BankResource($this->bankObj),
            "name" => $this->name,
            "number" => $this->number,
            "country" => new CountryResource($this->country)
        ];
    }
}
