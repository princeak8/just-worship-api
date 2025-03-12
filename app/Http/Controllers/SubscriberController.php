<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Subscribe;

use App\Http\Resources\SubscriberResource;

use App\Services\SubscriberService;

use App\Utilities;

class SubscriberController extends Controller
{
    private $subscriberService;

    public function __construct()
    {
        $this->subscriberService = new SubscriberService;
    }

    public function subscribe(Subscribe $request)
    {
        $data = $request->validated();

        $subscriber = $this->subscriberService->save($data);

        return Utilities::okay("Subscribed Successfully");
    }

    public function subscribers()
    {
        $subscribers = $this->subscriberService->subscribers();

        return Utilities::ok(SubscriberResource::collection($subscribers));
    }
}
