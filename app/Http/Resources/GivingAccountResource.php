<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\BankAccountResource;
use App\Http\Resources\OnlineAccountResource;
use App\Http\Resources\GivingOptionResource;

class GivingAccountResource extends JsonResource
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
            "account" => ($this->bank_account_id) ? new BankAccountResource($this->account) : new OnlineAccountResource($this->account),
            "option" => new GivingOptionResource($this->givingOption)
        ];
    }
}
