<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function givingAccounts()
    {
        return $this->hasMany(GivingAccount::class);
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (BankAccount $account) {
            if($account->givingAccounts->count() > 0) {
                foreach($account->givingAccounts as $givingAccount) {
                    $givingAccount->delete();
                }
            }
        });
    }
}
