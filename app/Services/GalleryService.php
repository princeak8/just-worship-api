<?php

namespace App\Services;

use App\Models\Gallery;

class GalleyService
{
    public function save($data)
    {
        $gallery = new Gallery;
        $gallery->photo_id = $data['photoId'];
        if(isset($data['eventId'])) $gallery->event_id = $data['eventId'];
        $gallery->save();

        return $gallery;
    }

    public function update($data, $gallery)
    {
        if(isset($data['photoId'])) $gallery->photo_id = $data['photoId'];
        if(isset($data['eventId'])) $gallery->event_id = $data['eventId'];
        $gallery->update();

        return $gallery;
    }

    public function gallery()
    {
        return Gallery::all();
    }

    public function galleryPhoto($id)
    {
        return Gallery::find($id);
    }
}