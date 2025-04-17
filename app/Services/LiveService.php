<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Live;

class LiveService
{
    public function save($data)
    {
        $live = new live;
        $live->title = $data['title'];
        $live->url = $data['url'];
        $live->cover_photo_id = $data['coverPhotoId'];
        $live->live_date = $data['liveDate'];
        if(isset($data['liveTime'])) $live->live_time = Carbon::createFromFormat('H:i', $data['liveTime'])->format('H:i:s');
        if(isset($data['description'])) $live->description = $data['description'];
        $live->save();

        return $live;
    }

    public function update($data, $live)
    {
        if(isset($data['title'])) $live->title = $data['title'];
        if(isset($data['coverPhotoId'])) $live->cover_photo_id = $data['coverPhotoId'];
        if(isset($data['liveDate'])) $live->live_date = $data['liveDate'];
        if(isset($data['liveTime'])) $live->live_time = Carbon::createFromFormat('H:i', $data['liveTime'])->format('H:i:s');
        if(isset($data['description'])) $live->description = $data['description'];

        $live->update();

        return $live;
    }

    public function lives()
    {
        return Live::orderBy("live_date", "DESC")->get();
    }

    public function live($id, $with=[])
    {
        return Live::with($with)->where("id", $id)->first();
    }

    public function delete($live)
    {
        $live->delete();
    }
}