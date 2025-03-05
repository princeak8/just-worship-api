<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    public function save($data)
    {
        $team = new Team;
        $team->name = $data['name'];
        $team->photo_id = $data['photoId'];
        $team->position = $data['position'];
        if(isset($data['biography'])) $team->biography = $data['biography'];
        $team->save();

        return $team;
    }

    public function update($data, $team)
    {
        if(isset($data['name'])) $team->name = $data['name'];
        if(isset($data['photoId'])) $team->photo_id = $data['photoId'];
        if(isset($data['position'])) $team->position = $data['position'];
        if(isset($data['biography'])) $team->biography = $data['biography'];

        $team->update();

        return $team;
    }

    public function team()
    {
        return Team::all();
    }

    public function teamMember($id)
    {
        return Team::find($id);
    }

    public function delete($member)
    {
        $member->delete();
    }
}