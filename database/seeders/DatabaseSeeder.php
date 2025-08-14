<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\GivingModes;
use Database\Seeders\GivingOptions;
use Database\Seeders\Users;
use Database\Seeders\Countries;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $seeders = [
            new GivingModes,
            new GivingOptions,
            new Users,
            new Countries
        ];

        foreach($seeders as $seeder) $seeder->run();
    }
}
