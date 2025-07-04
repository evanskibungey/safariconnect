<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Nairobi',
                'is_active' => true,
            ],
            [
                'name' => 'Mombasa',
                'is_active' => true,
            ],
            [
                'name' => 'Kisumu',
                'is_active' => true,
            ],
            [
                'name' => 'Nakuru',
                'is_active' => true,
            ],
            [
                'name' => 'Eldoret',
                'is_active' => true,
            ],
            [
                'name' => 'Meru',
                'is_active' => true,
            ],
            [
                'name' => 'Nyeri',
                'is_active' => true,
            ],
            [
                'name' => 'Kisii',
                'is_active' => true,
            ],
            [
                'name' => 'Kakamega',
                'is_active' => true,
            ],
            [
                'name' => 'Thika',
                'is_active' => true,
            ],
        ];

        foreach ($cities as $cityData) {
            City::updateOrCreate(
                ['name' => $cityData['name']],
                $cityData
            );
        }
    }
}
