<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\BookEvent;

use App\Http\Resources\EventResource;

use App\Services\EventService;
use App\Services\FileService;

use App\Utilities;

class EventController extends Controller
{
    private $eventService;
    private $fileService;

    public function __construct()
    {
        $this->eventService = new EventService;
        $this->fileService = new FileService;
    }

    public function save(AddEvent $request)
    {
        $data = $request->validated();
        
        $fileData = [
            "file" => $request->file('coverPhoto'),
            "fileType" => 'image'
        ];
        $file = $this->fileService->save($fileData, 'events');
        $data['coverPhotoId'] = $file->id;

        $event = $this->eventService->save($data);

        return Utilities::ok(new EventResource($event));
    }

    public function update($eventId, UpdateEvent $request)
    {
        if (!is_numeric($eventId) || !ctype_digit($eventId)) return Utilities::error402("Invalid parameter eventId");

        $event = $this->eventService->event($eventId);
        if(!$event) return Utilities::error402("Event not found");

        $data = $request->validated();
        $oldCoverPhoto = null;
        
        if($request->hasFile('coverPhoto')) {
            $oldCoverPhoto = $event->coverPhoto;
            $fileData = [
                "file" => $request->file('coverPhoto'),
                "fileType" => 'image'
            ];
            $file = $this->fileService->save($fileData, 'events');
            $data['coverPhotoId'] = $file->id;
        }

        $event = $this->eventService->update($data, $event);

        if($oldCoverPhoto) $oldCoverPhoto->delete();

        return Utilities::ok(new EventResource($event));
    }

    public function event($eventId)
    {
        if (!is_numeric($eventId) || !ctype_digit($eventId)) return Utilities::error402("Invalid parameter eventId");

        $event = $this->eventService->event($eventId);
        if(!$event) return Utilities::error402("Event not found");

        return Utilities::ok(new EventResource($event));
    }

    public function events()
    {
        $events = $this->eventService->events();

        return Utilities::ok(EventResource::collection($events));
    }

    public function delete($eventId)
    {
        if (!is_numeric($eventId) || !ctype_digit($eventId)) return Utilities::error402("Invalid parameter eventId");

        $event = $this->eventService->event($eventId);
        if(!$event) return Utilities::error402("Event not found");

        $this->eventService->delete($event);

        return Utilities::okay("Event deleted Successfully");
    }

    public function book(BookEvent $request)
    {
        $data = $request->validated();
        $event = $this->eventService->event($data['eventId']);

        if(!$event) return Utilities::error402("Event not found");

        $this->eventService->book($data);

        return Utilities::okay("Event has been Booked Successfully");
    }
}
