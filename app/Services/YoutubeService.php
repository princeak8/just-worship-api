<?php

namespace App\Services;

use App\Models\Youtube;

class YoutubeService
{
    public function save($data)
    {
        $youtube = Youtube::first();
        if(!isset($youtube)) $youtube = new Youtube();

        if(isset($data['title'])) $youtube->title = $data['title'];
        if(isset($data['url'])) $youtube->url = $data['url'];
        $youtube->save();

        return $youtube;
    }

    public function youtube()
    {
        return Youtube::first();
    }
}