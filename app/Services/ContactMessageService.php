<?php

namespace App\Services;

use App\Models\ContactMessage;

class ContactMessageService
{
    public function save($data)
    {
        $message = new ContactMessage;
        $message->name = $data['name'];
        $message->message = $data['message'];
        $message->save();

        return $message;
    }

    public function messages()
    {
        return ContactMessage::all();
    }

    public function message($id)
    {
        return ContactMessage::find($id);
    }
}