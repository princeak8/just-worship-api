<?php

namespace App\Services;

use App\Models\Gallery;

class GalleryService
{
    public function save($data)
    {
        $gallery = new Gallery;
        $gallery->photo_id = $data['photoId'];
        if(isset($data['eventId'])) $gallery->event_id = $data['eventId'];
        if(isset($data['title'])) $gallery->title = $data['title'];
        if(isset($data['year'])) $gallery->year = $data['year'];
        if(isset($data['location'])) $gallery->location = $data['location'];
        $gallery->save();

        return $gallery;
    }

    public function update($data, $gallery)
    {
        if(isset($data['photoId'])) $gallery->photo_id = $data['photoId'];
        if(isset($data['eventId'])) $gallery->event_id = $data['eventId'];
        if(isset($data['title'])) $gallery->title = $data['title'];
        if(isset($data['year'])) $gallery->year = $data['year'];
        if(isset($data['location'])) $gallery->location = $data['location'];
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

    public function delete($gallery)
    {
        $gallery->delete();
    }
}