<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    public function teams()
    {
        return $this->belongsToMany(VolunteeringTeam::class, "volunteer_teams", "volunteer_id", "team_id");
    }

    public function volunteerTeams()
    {
        $this->hasMany(VolunteerTeam::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (Volunteer $volunteer) {
            if($volunteer->volunteerTeams->count() > 0) {
                foreach($volunteer->volunteerTeams as $team) {
                    $team->delete();
                }
            }
        });
    }
}
