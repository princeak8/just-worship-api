<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivingPartner extends Model
{
    protected $casts = [
        'recurrent' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Scopes
    public function scopeRecurrent($query)
    {
        return $query->where('recurrent', true);
    }

    public function scopeOneTime($query)
    {
        return $query->where('recurrent', false);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->surname;
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    

    public function givingOption()
    {
        return $this->belongsTo(GivingOption::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }
}
