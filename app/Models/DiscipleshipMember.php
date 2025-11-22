<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscipleshipMember extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function discipleship()
    {
        return $this->belongsTo(Discipleship::class);
    }
}
