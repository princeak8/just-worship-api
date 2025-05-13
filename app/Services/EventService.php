<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Event;
use App\Models\EventBooking;

class EventService
{
    public function save($data)
    {
        $event = new Event;
        $event->name = $data['name'];
        $event->cover_photo_id = $data['coverPhotoId'];
        $event->event_date = $data['eventDate'];
        if(isset($data['eventTime'])) $event->event_time = Carbon::createFromFormat('h:i A', $data['eventTime'])->format('H:i:s');
        if(isset($data['location'])) $event->location = $data['location'];
        if(isset($data['content'])) $event->content = $data['content'];
        if(isset($data['featured'])) $event->featured = $data['featured'];
        $event->save();

        return $event;
    }

    public function update($data, $event)
    {
        if(isset($data['name'])) $event->name = $data['name'];
        if(isset($data['coverPhotoId'])) $event->cover_photo_id = $data['coverPhotoId'];
        if(isset($data['eventDate'])) $event->event_date = $data['eventDate'];
        if(isset($data['eventTime'])) $event->event_time = Carbon::createFromFormat('h:i A', $data['eventTime'])->format('H:i:s');
        if(isset($data['location'])) $event->location = $data['location'];
        if(isset($data['content'])) $event->content = $data['content'];
        if(isset($data['featured'])) $event->featured = $data['featured'];

        $event->update();

        return $event;
    }

    public function events()
    {
        return Event::orderBy("created_at", "DESC")->get();
    }

    public function event($id, $with=[])
    {
        return Event::with($with)->where("id", $id)->first();
    }

    public function eventByName($name)
    {
        return  Event::where("name", $name)->first();
    }

    public function delete($event)
    {
        $event->delete();
    }

    public function book($data)
    {
        $eventBook = new EventBooking;
        $eventBook->event_id = $data['eventId'];
        $eventBook->name = $data['name'];
        $eventBook->email = $data['email'];

        $eventBook->save();

        return $eventBook;
    }
}