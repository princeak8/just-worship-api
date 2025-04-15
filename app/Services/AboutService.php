<?php

namespace App\Services;

use App\Models\About;

class AboutService
{
    public function save($data)
    {
        $about = About::first();
        if(!$about) $about = new About;
        if(isset($data['vision'])) $about->vision = $data['vision'];
        if(isset($data['visionPhotoId'])) $about->vision_photo_id = $data['visionPhotoId'];
        
        if(isset($data['mission'])) $about->mission = $data['mission'];
        if(isset($data['missionPhotoId'])) $about->mission_photo_id = $data['missionPhotoId'];
        
        if(isset($data['header'])) $about->header = $data['header'];
        if(isset($data['content'])) $about->content = $data['content'];
        if(isset($data['pastorTitle'])) $about->pastor_title = $data['pastorTitle'];
        if(isset($data['pastorBio'])) $about->pastor_bio = $data['pastorBio'];
        if(isset($data['pastorPhotoId'])) $about->pastor_photo_id = $data['pastorPhotoId'];
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