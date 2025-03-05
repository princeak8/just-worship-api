<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveContactInfo;

use App\Http\Resources\ContactResource;

use App\Services\ContactService;
use App\Models\Contact;

use App\Utilities;

class ContactController extends Controller
{
    private $contactService;

    public function __construct()
    {
        $this->contactService = new ContactService;
    }

    public function save(SaveContactInfo $request)
    {
        $data = $request->validated();

        $info = $this->contactService->save($data);

        return Utilities::ok(new ContactResource($info));
    }

    public function contactInfo()
    {
        $contactInfo = $this->contactService->contact();

        if(!$contactInfo) $contactInfo = new Contact;

        return Utilities::ok(new ContactResource($contactInfo));
    }
}
