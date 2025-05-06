<?php

namespace App\Services;

use App\Models\Music;

class MusicService
{
    public function save($data)
    {
        $music = new Music;
        $music->name = $data['name'];    
        $music->artist = $data['artist'];
        $music->featuring = $data['featuring'];
        $music->link = $data['link'];
        $music->cover_photo_id = $data['coverPhotoId'];
        $music->save();

        return $music;
    }

    public function update($data, $music)
    {
        if(isset($data['name'])) $music->name = $data['name'];    
        if(isset($data['artist'])) $music->artist = $data['artist'];
        if(isset($data['featuring'])) $music->featuring = $data['featuring'];
        if(isset($data['link'])) $music->link = $data['link'];
        if(isset($data['coverPhotoId'])) $music->cover_photo_id = $data['coverPhotoId'];
        $music->update();

        return $music;
    }

    public function setDefault($music)
    {
        $currentDefault = Music::where("default", 1)->first();
        if($currentDefault && $currentDefault->id != $music->id) {
            $music->default = true;
            $music->update();
        }
    }

    public function getAllMusic()
    {
        return Music::orderBy("created_at", "DESC")->get();
    }

    public function getMusic($musicId)
    {
        return Music::find($musicId);
    }

    public function delete($music)
    {
        $music->delete();
    }
}