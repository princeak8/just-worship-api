<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivingOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name'
    ];

    public function givingAccounts()
    {
        return $this->hasMany(GivingAccount::class);
    }
    
    public function accounts()
    {
        return ($this->bank_account_id) ? 
            $this->belongsToMany(BankAccount::class, "giving_accounts", "giving_option_id", "bank_account_id")
            :
            $this->belongsToMany(OnlineAccount::class, "giving_accounts", "giving_option_id", "online_account_id");
    }
}
