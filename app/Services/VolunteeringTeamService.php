<?php

namespace App\Services;

use App\Models\VolunteeringTeam;

class VolunteeringTeamService
{
    public function save($data)
    {
        $team = new VolunteeringTeam;
        $team->name = $data['name'];    
        $team->task = $data['task'];
        if(isset($data['description'])) $team->description = $data['description'];
        $team->save();

        return $team;
    }

    public function update($data, $team)
    {
        if(isset($data['name'])) $team->name = $data['name'];    
        if(isset($data['task'])) $team->task = $data['task'];
        if(isset($data['description'])) $team->description = $data['description'];
        $team->update();

        return $team;
    }

    public function getAllTeam($with=[])
    {
        return VolunteeringTeam::with($with)->orderBy("created_at", "DESC")->get();
    }

    public function getTeam($teamId, $with=[])
    {
        return VolunteeringTeam::with($with)->where("id", $teamId)->first();
    }

    public function delete($team)
    {
        $team->delete();
    }
}