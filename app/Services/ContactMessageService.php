<?php

namespace App\Services;

use App\Models\ContactMessage;

class ContactMessageService
{
    public function save($data)
    {
        $message = new ContactMessage;
        $message->title = $data['title'];
        $message->name = $data['name'];
        if(isset($data['email'])) $message->email = $data['email'];
        $message->message = $data['message'];
        $message->save();

        return $message;
    }

    public function messages()
    {
        return ContactMessage::all();
    }

    public function unreadMessages()
    {
        return ContactMessage::where("read", 0)->get();
    }

    public function message($id)
    {
        $message = ContactMessage::find($id);
        if($message && $message->read == 0) {
            $message->read = true;
            $message->update();
        }

        return $message;
    }
}