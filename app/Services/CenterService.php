<?php

namespace App\Services;

use App\Models\Center;

class CenterService
{
    public function save($data)
    {
        $center = new Center;
        $center->name = $data['name'];    
        $center->artist = $data['artist'];
        $center->featuring = $data['featuring'];
        $center->link = $data['link'];
        $center->cover_photo_id = $data['coverPhotoId'];
        $center->save();

        return $center;
    }

    public function update($data, $center)
    {
        if(isset($data['name'])) $center->name = $data['name'];    
        if(isset($data['artist'])) $center->artist = $data['artist'];
        if(isset($data['featuring'])) $center->featuring = $data['featuring'];
        if(isset($data['link'])) $center->link = $data['link'];
        if(isset($data['coverPhotoId'])) $center->cover_photo_id = $data['coverPhotoId'];
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