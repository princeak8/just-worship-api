<?php

namespace App\Services;

use App\Models\Discipleship;
use App\Models\DiscipleshipMember;

class DiscipleshipService
{
    public function save($data)
    {
        $discipleship = new Discipleship;
        $discipleship->name = $data['name'];    
        $discipleship->year = $data['year'];
        $discipleship->month = $data['month'];
        if(isset($data['countryId'])) $discipleship->country_id = $data['countryId'];
        if(isset($data['venue'])) $discipleship->venue = $data['venue'];
        if(isset($data['online'])) $discipleship->online = $data['online'];
        if(isset($data['link'])) $discipleship->link = $data['link'];
        if(isset($data['open'])) $discipleship->open = $data['open'];
        if(isset($data['deadline'])) $discipleship->deadline = $data['deadline'];
        $discipleship->save();

        return $discipleship;
    }

    public function update($data, $discipleship)
    {
        if(isset($data['name'])) $discipleship->name = $data['name'];    
        if(isset($data['year'])) $discipleship->year = $data['year'];
        if(isset($data['month'])) $discipleship->month = $data['month'];
        if(isset($data['year'])) $discipleship->year = $data['year'];
        if(isset($data['countryId'])) $discipleship->country_id = $data['countryId'];
        if(isset($data['venue'])) $discipleship->venue = $data['venue'];
        if(isset($data['online'])) $discipleship->online = $data['online'];
        if(isset($data['link'])) $discipleship->link = $data['link'];
        if(isset($data['open'])) $discipleship->open = $data['open'];
        if(isset($data['deadline'])) $discipleship->deadline = $data['deadline'];
        $discipleship->update();

        return $discipleship;
    }

    public function join($discipleship, $data)
    {
        $member = new DiscipleshipMember;
        $member->discipleship_id = $discipleship->id;
        $member->firstname = $data['firstname'];
        $member->surname = $data['surname'];
        $member->email = $data['email'];
        $member->phone_number = $data['phoneNumber'];
        if(isset($data['countryId'])) $member->country_id = $data['countryId'];
        if(isset($data['city'])) $member->city = $data['city'];
        $member->save();

        return $member;
    }

    public function getDiscipleships($with=[])
    {
        return Discipleship::with($with)->orderBy("created_at", "DESC")->get();
    }

    public function getCurrentDiscipleship($with=[])
    {
        return Discipleship::with($with)->where("open", 1)->orderBy("year", "DESC")->orderBy("month", "DESC")->first();
    }

    public function getDiscipleship($discipleshipId, $with=[])
    {
        return Discipleship::with($with)->where("id", $discipleshipId)->first();
    }

    public function open($discipleship)
    {
        $this->closeAll();

        $discipleship->open = 1;
        $discipleship->update();

        return $discipleship;
    }

    public function closeAll()
    {
        $discipleships = $this->getDiscipleships();
        if($discipleships->count() > 0) {
            foreach($discipleships as $discipleship) $this->close($discipleship);
        }
    }

    public function close($discipleship)
    {
        $discipleship->open = 0;
        $discipleship->update();

        return $discipleship;
    }

    public function delete($discipleship)
    {
        $discipleship->delete();
    }
}