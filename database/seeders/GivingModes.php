<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GivingMode;

class GivingModes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = ["Debit Card", "Credit Card", "Transfer"];

        foreach($modes as $mode) GivingMode::firstOrCreate(["name" => $mode]);
    }
}
