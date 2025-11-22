<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipleship extends Model
{
    public function members()
    {
        return $this->hasMany(DiscipleshipMember::class, "discipleship_id", "id");
    }

    public function photo()
    {
        return $this->belongsTo(File::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
