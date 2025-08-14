<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\CountryResource;
use App\Http\Resources\GivingOptionResource;

class GivingPartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'surname' => $this->surname,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => new CountryResource($this->country),
            'givingOption' => new GivingOptionResource($this->givingOption),
            'recurrent' => $this->recurrent,
            'recurrentType' => $this->recurrent_type,
            'amount' => $this->amount,
            'formattedAmount' => $this->formatted_amount,
            'prayerPoint' => $this->prayer_point,
            'createdAt' => $this->created_at?->toDateTimeString(),
        ];
    }
}
