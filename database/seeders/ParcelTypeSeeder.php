<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParcelType;

class ParcelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parcelTypes = [
            [
                'name' => 'Documents',
                'description' => 'Letters, contracts, certificates, and other paper documents',
                'max_weight_kg' => 2.0,
                'max_dimensions' => '35x25x5 cm',
                'base_rate' => 200.00,
                'is_active' => true,
            ],
            [
                'name' => 'Small Package',
                'description' => 'Electronics, books, jewelry, small household items',
                'max_weight_kg' => 5.0,
                'max_dimensions' => '40x30x20 cm',
                'base_rate' => 350.00,
                'is_active' => true,
            ],
            [
                'name' => 'Medium Package',
                'description' => 'Clothing, shoes, medium electronics, gifts',
                'max_weight_kg' => 15.0,
                'max_dimensions' => '60x40x40 cm',
                'base_rate' => 500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Large Package',
                'description' => 'Home appliances, furniture parts, bulk items',
                'max_weight_kg' => 30.0,
                'max_dimensions' => '80x60x60 cm',
                'base_rate' => 800.00,
                'is_active' => true,
            ],
            [
                'name' => 'Extra Large',
                'description' => 'Oversized items, furniture, special cargo',
                'max_weight_kg' => 50.0,
                'max_dimensions' => '120x80x80 cm',
                'base_rate' => 1200.00,
                'is_active' => true,
            ],
        ];

        foreach ($parcelTypes as $parcelTypeData) {
            ParcelType::updateOrCreate(
                ['name' => $parcelTypeData['name']],
                $parcelTypeData
            );
        }
    }
}
