<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Bank;

class UtilityService
{
    public function countries()
    {
       return Country::all();
    }

    public function banks()
    {
        return Bank::all();
    }
}