<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CountryResource;

use App\Services\UtilityService;

use App\Utilities;

class UtilityController extends Controller
{
    private $utilityService;

    public function __construct()
    {
        $this->utilityService = new UtilityService;
    }

    public function countries()
    {
        $countries = $this->utilityService->countries();

        return Utilities::ok(CountryResource::collection($countries));
    }
}
