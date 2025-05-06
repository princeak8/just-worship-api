<?php

namespace App\Services;

use App\Models\Slide;

class SlideService
{
    public function save($data)
    {
        $slide = new Slide;
        if(isset($data['title'])) $slide->title = $data['title'];
        $slide->photo_id = $data['photoId'];
        if(isset($data['message'])) $slide->message = $data['message'];
        if(isset($data['buttonText'])) $slide->button_text = $data['buttonText'];
        if(isset($data['buttonUrl'])) $slide->button_url = $data['buttonUrl'];
        $slide->save();

        return $slide;
    }

    public function update($data, $slide)
    {
        if(isset($data['title'])) $slide->title = $data['title'];
        if(isset($data['photoId'])) $slide->photo_id = $data['photoId'];
        if(isset($data['message'])) $slide->message = $data['message'];
        if(isset($data['buttonText'])) $slide->button_text = $data['buttonText'];
        if(isset($data['buttonUrl'])) $slide->button_url = $data['buttonUrl'];
        $slide->update();

        return $slide;
    }

    public function slides()
    {
        return Slide::orderBy("created_at", "DESC")->get();
    }

    public function slide($id)
    {
        return Slide::find($id);
    }

    public function delete($slide)
    {
        $slide->delete();
    }
}