<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\BankAccountResource;
use App\Http\Resources\OnlineAccountResource;

class GivingOptionResource extends JsonResource
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
            "accounts" => $this->accounts()
        ];
    }

    private function accounts()
    {
        $accounts = [];
        if($this->givingAccounts->count() > 0) {
            foreach($this->givingAccounts as $givingAcc) {
                $accounts[] = ($givingAcc->bank_account_id) ? new BankAccountResource($givingAcc->account) : new OnlineAccountResource($givingAcc->account);
            }
        }
        return $accounts;
    }
}
