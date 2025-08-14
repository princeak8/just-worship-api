<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GivingPartner;

use App\Enums\Currency;
use App\ENums\GivingRecurrentType;

class Partners extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partner = new GivingPartner;

        $partner->firstname = "Eunice";
        $partner->surname = "Stefford";
        $partner->email = "eunice@gmail.com";
        $partner->country_id = 216;
        $partner->phone = "256-432-812-87";
        $partner->recurrent = true;
        $partner->recurrent_type = GivingRecurrentType::YEARLY->value;
        $partner->amount = 5000;
        $partner->currency = Currency::DOLLAR->value;
        $partner->prayer_point = "I need a Child";

        $partner->save();
    }
}
