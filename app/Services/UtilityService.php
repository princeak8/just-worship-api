<?php

namespace App\Services;

use App\Models\Country;

class UtilityService
{
    public function countries()
    {
       return Country::all();
    }
}