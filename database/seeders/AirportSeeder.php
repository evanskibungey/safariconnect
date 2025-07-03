<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airport;
use App\Models\City;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First create some basic cities if they don't exist
        $citiesData = [
            ['name' => 'Nairobi', 'state' => 'Nairobi County', 'country' => 'Kenya'],
            ['name' => 'Mombasa', 'state' => 'Mombasa County', 'country' => 'Kenya'],
            ['name' => 'Kisumu', 'state' => 'Kisumu County', 'country' => 'Kenya'],
            ['name' => 'Eldoret', 'state' => 'Uasin Gishu County', 'country' => 'Kenya'],
            ['name' => 'Nakuru', 'state' => 'Nakuru County', 'country' => 'Kenya'],
        ];

        foreach ($citiesData as $cityData) {
            City::firstOrCreate(
                ['name' => $cityData['name']],
                array_merge($cityData, ['is_active' => true])
            );
        }

        // Now get the cities for airports
        $nairobi = City::where('name', 'Nairobi')->first();
        $mombasa = City::where('name', 'Mombasa')->first();
        $kisumu = City::where('name', 'Kisumu')->first();
        $eldoret = City::where('name', 'Eldoret')->first();
        $nakuru = City::where('name', 'Nakuru')->first();

        $airports = [
            [
                'name' => 'Jomo Kenyatta International Airport',
                'code' => 'JKIA',
                'city_id' => $nairobi->id,
                'description' => 'Kenya\'s largest airport and main international gateway, located in Nairobi.',
                'is_active' => true,
            ],
            [
                'name' => 'Wilson Airport',
                'code' => 'WIL',
                'city_id' => $nairobi->id,
                'description' => 'Domestic airport in Nairobi, primarily for domestic flights and charter services.',
                'is_active' => true,
            ],
            [
                'name' => 'Moi International Airport',
                'code' => 'MBA',
                'city_id' => $mombasa->id,
                'description' => 'International airport serving Mombasa and the Kenyan coast.',
                'is_active' => true,
            ],
            [
                'name' => 'Kisumu International Airport',
                'code' => 'KIS',
                'city_id' => $kisumu->id,
                'description' => 'International airport serving Kisumu and western Kenya.',
                'is_active' => true,
            ],
            [
                'name' => 'Eldoret International Airport',
                'code' => 'EDL',
                'city_id' => $eldoret->id,
                'description' => 'International airport serving Eldoret and the Rift Valley region.',
                'is_active' => true,
            ]
        ];

        foreach ($airports as $airportData) {
            Airport::firstOrCreate(
                ['name' => $airportData['name']],
                $airportData
            );
        }

        $this->command->info('Cities and airports seeded successfully!');
        $this->command->info('Created/verified ' . City::count() . ' cities');
        $this->command->info('Created/verified ' . Airport::count() . ' airports');
    }
}
