<?php

namespace App\Services;

use App\Models\Slide;

class SlideService
{
    public function save($data)
    {
        $slide = new Slide;
        $slide->photo_id = $data['photoId'];
        if(isset($data['message'])) $slide->message = $data['message'];
        if(isset($data['buttonText'])) $slide->button_text = $data['buttonText'];
        $slide->save();

        return $slide;
    }

    public function update($data, $slide)
    {
        if(isset($data['photoId'])) $slide->photo_id = $data['photoId'];
        if(isset($data['message'])) $slide->message = $data['message'];
        if(isset($data['buttonText'])) $slide->button_text = $data['buttonText'];
        $slide->update();

        return $slide;
    }

    public function slides()
    {
        return Slide::all();
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