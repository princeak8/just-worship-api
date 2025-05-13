<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteeringTeam extends Model
{
    public function volunteers()
    {
        return $this->belongsToMany(Volunteer::class, "volunteer_teams", "team_id", "volunteer_id");
    }

    public function volunteerTeams()
    {
        return $this->hasMany(VolunteerTeam::class, "team_id", "id");
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (VolunteeringTeam $team) {
            if($team->volunteerTeams->count() > 0) {
                foreach($team->volunteerTeams as $vTeam) {
                    $vTeam->delete();
                }
            }
        });
    }
}
