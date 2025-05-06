<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerTeam extends Model
{
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
