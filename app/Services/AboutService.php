<?php

namespace App\Services;

use App\Models\About;

class AboutService
{
    public function save($data)
    {
        $about = new About;
        if(isset($data['vision'])) {
            $about->vision = $data['vision'];
            $about->vision_photo_id = $data['visionPhotoId'];
        }
        if(isset($data['mission'])) {
            $about->mission = $data['mission'];
            $about->mission_photo_id = $data['missionPhotoId'];
        }
        $about->save();

        return $about;
    }

    public function update($data, $about)
    {
        if(isset($data['vision'])) {
            $about->vision = $data['vision'];
            $about->vision_photo_id = $data['visionPhotoId'];
        }
        if(isset($data['mission'])) {
            $about->mission = $data['mission'];
            $about->mission_photo_id = $data['missionPhotoId'];
        }
        $about->update();

        return $about;
    }

    public function about()
    {
        return About::first();
    }
}