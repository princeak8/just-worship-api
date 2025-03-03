<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CountriesData;

use App\Models\Country;

class Countries extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryList = new CountriesData;
        $countries = $countryList->countries;

        if(count($countries) > 0) {
            foreach($countries as $code=>$country) {
                Country::firstOrCreate([
                    "name" => $country,
                    "code" => $code
                ]);
            }
        }
    }
}
