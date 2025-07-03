<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CheckCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();
        
        $this->command->info("Current cities in database:");
        foreach ($cities as $city) {
            $this->command->info("ID: {$city->id} - Name: {$city->name} - State: {$city->state} - Country: {$city->country}");
        }
        
        if ($cities->count() === 0) {
            $this->command->warn("No cities found in database. You need to create cities before adding airports.");
        }
    }
}
