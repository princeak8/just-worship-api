<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveContactMessage;

use App\Http\Resources\ContactMessageResource;

use App\Services\ContactMessageService;

use App\Utilities;

class ContactMessageController extends Controller
{
    private $contactMessageService;

    public function __construct()
    {
        $this->contactMessageService = new ContactMessageService;
    }

    public function save(SaveContactMessage $request)
    {
        $data = $request->validated();

        $message = $this->contactMessageService->save($data);

        return Utilities::ok(new ContactMessageResource($message));
    }

    public function messages()
    {
        $messages = $this->contactMessageService->messages();

        return Utilities::ok(ContactMessageResource::collection($messages));
    }

    public function unreadMessages()
    {
        $messages = $this->contactMessageService->unreadMessages();

        return Utilities::ok(ContactMessageResource::collection($messages));
    }

    public function message($messageId)
    {
        if (!is_numeric($messageId) || !ctype_digit($messageId)) return Utilities::error402("Invalid parameter messageId");

        $message = $this->contactMessageService->message($messageId);

        if(!$message) return Utilities::error402("Message not found");

        return Utilities::ok(new ContactMessageResource($message));
    }
}
