<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivingOption extends Model
{
    public function accounts()
    {
        return $this->belongsToMany(BankAccount::class, "giving_bank_accounts", "giving_option_id", "bank_account_id");
    }
}
