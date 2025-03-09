<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GivingOption;

class GivingOptions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = ["Partnership", "Tithe & Offering", "Donations"];

        foreach($options as $option) GivingOption::firstOrCreate(["name" => $option]);
    }
}
