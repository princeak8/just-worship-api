<?php

namespace App\Services;

use App\Models\Subscriber;

class SubscriberService
{
    public function save($data)
    {
        $subscriber = new Subscriber;

        if(isset($data['name'])) $subscriber->name = $data['name'];
        $subscriber->email = $data['email'];
        $subscriber->save();

        return $subscriber;
    }

    public function subscribers()
    {
        return Subscriber::all();
    }

    public function getById($id)
    {
        return Subscriber::find($id);
    }

    public function getByEmail($email)
    {
        return Subscriber::where("email", $email)->first();
    }

    public function delete($subscriber)
    {
        $subscriber->delete();
    }
}