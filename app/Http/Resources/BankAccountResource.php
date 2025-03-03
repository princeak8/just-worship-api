<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CountryResource;

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
            "bank" => $this->bank,
            "name" => $this->name,
            "number" => $this->number,
            "country" => new CountryResource($this->country)
        ];
        /*
            $table->foreignId("country_id");
            $table->string("bank");
            $table->string("name");
            $table->string("number");
        */
    }
}
