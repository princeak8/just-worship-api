<?php

namespace App\Services;

use App\Models\Volunteer;
use App\Models\VolunteerTeam;

class VolunteerService
{
    public function save($data)
    {
        $volunteer = new Volunteer;
        $volunteer->name = $data['name'];    
        $volunteer->email = $data['email'];
        $volunteer->phone_number = $data['phoneNumber'];
        $volunteer->country_id = $data['countryId'];
        $volunteer->city = $data['city'];
        $volunteer->save();

        return $volunteer;
    }

    public function joinTeam($volunteer, $team)
    {
        $volunteerTeam = new VolunteerTeam;
        $volunteerTeam->volunteer_id = $volunteer->id;
        $volunteerTeam->team_id = $team->id;
        $volunteerTeam->save();
    }

    public function getVolunteers($with=[])
    {
        return Volunteer::with($with)->orderBy("created_at", "DESC")->get();
    }

    public function getVolunteer($volunteerId, $with=[])
    {
        return Volunteer::with($with)->where("id", $volunteerId)->first();
    }

    public function delete($volunteer)
    {
        $volunteer->delete();
    }
}