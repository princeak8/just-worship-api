<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
    ];

    public function givingPartners()
    {
        return $this->hasMany(GivingPartner::class, 'country_code', 'code');
    }
}
