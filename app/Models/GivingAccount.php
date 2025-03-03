<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivingAccount extends Model
{
    public function givingOption()
    {
        return $this->belongsTo(GivingOption::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
