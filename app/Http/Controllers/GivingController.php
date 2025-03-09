<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LinkGivingAccount;

use App\Http\Resources\GivingAccountResource;
use App\Http\Resources\GivingModeResource;
use App\Http\Resources\GivingOptionResource;

use App\Services\GivingService;

use App\Utilities;

class GivingController extends Controller
{
    
    private $givingService;

    public function __construct()
    {
        $this->givingService = new GivingService;
    }

    public function linkGivingAccount(LinkGivingAccount $request)
    {
        $data = $request->validated();

        $givingAccount = $this->givingService->saveGivingAccount($data);

        return Utilities::ok(new GivingAccountResource($givingAccount));
    }

    public function givingModes()
    {
        $modes = $this->givingService->modes();

        return Utilities::ok(GivingModeResource::collection($modes));
    }

    public function givingOptions()
    {
        $options = $this->givingService->options();

        return Utilities::ok(GivingOptionResource::collection($options));
    }

    public function give()
    {
        
    }
}
