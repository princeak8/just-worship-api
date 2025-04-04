<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivingAccount extends Model
{
    public function givingOption()
    {
        return $this->belongsTo(GivingOption::class);
    }

    public function account()
    {
        return ($this->bank_account_id) ? $this->belongsTo(BankAccount::class, "bank_account_id", "id") : $this->belongsTo(OnlineAccount::class, "online_account_id", "id");
    }
}
