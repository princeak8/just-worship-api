<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    public function save($data)
    {
        $contact = Contact::first();
        if(!isset($contact)) $contact = new Contact;

        if(isset($data['address'])) $contact->address = $data['address'];
        if(isset($data['email'])) $contact->email = $data['email'];
        if(isset($data['phoneNumber'])) $contact->phone_number = $data['phoneNumber'];
        $contact->save();

        return $contact;
    }

    public function contact()
    {
        return Contact::first();
    }
}