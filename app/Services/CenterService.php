<?php

namespace App\Services;

use App\Models\Center;

class CenterService
{
    public function save($data)
    {
        $center = new Center;
        $center->location = $data['location'];    
        $center->address = $data['address'];
        $center->photo_id = $data['photoId'];
        $center->country_id = $data['countryId'];
        if(isset($data['latitude'])) $center->latitude = $data['latitude'];
        if(isset($data['longitude'])) $center->longitude = $data['longitude'];
        $center->save();

        return $center;
    }

    public function update($data, $center)
    {
        if(isset($data['location'])) $center->location = $data['location'];    
        if(isset($data['address'])) $center->address = $data['address'];
        if(isset($data['photoId'])) $center->photo_id = $data['photoId'];
        if(isset($data['countryId'])) $center->country_id = $data['countryId'];
        if(isset($data['latitude'])) $center->latitude = $data['latitude'];
        if(isset($data['longitude'])) $center->longitude = $data['longitude'];
        $center->update();

        return $center;
    }

    public function getAllCenter()
    {
        return Center::orderBy("created_at", "DESC")->get();
    }

    public function getCenter($centerId)
    {
        return Center::find($centerId);
    }

    public function delete($center)
    {
        $center->delete();
    }
}