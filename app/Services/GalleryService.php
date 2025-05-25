<?php

namespace App\Services;

use App\Models\Gallery;

class GalleryService
{
    public $count = false;

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

    public function gallery($offset=0, $perPage=null)
    {
        $query = Gallery::query(); 
        
        if($this->count) return $query->count();

        if($perPage==null) $perPage=env('PAGINATION_PER_PAGE');
        return $query->offset($offset)->limit($perPage)->orderBy("created_at", "DESC")->get();
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