<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Airport;
use App\Models\TransportationService;

class CheckDatabaseData extends Command
{
    protected $signature = 'check:data';
    protected $description = 'Check if required data exists in the database';

    public function handle()
    {
        $this->info('Checking database data...');
        
        // Check cities
        $cities = City::all();
        $this->info("Cities found: " . $cities->count());
        foreach ($cities as $city) {
            $this->line("  - ID: {$city->id}, Name: {$city->name}, Active: " . ($city->is_active ? 'Yes' : 'No'));
        }
        
        // Check airports
        $airports = Airport::with('city')->get();
        $this->info("Airports found: " . $airports->count());
        foreach ($airports as $airport) {
            $cityName = $airport->city ? $airport->city->name : 'No city';
            $this->line("  - ID: {$airport->id}, Name: {$airport->name}, City: {$cityName}, Active: " . ($airport->is_active ? 'Yes' : 'No'));
        }
        
        // Check transportation services
        $services = TransportationService::all();
        $this->info("Transportation Services found: " . $services->count());
        foreach ($services as $service) {
            $this->line("  - ID: {$service->id}, Name: {$service->name}, Type: {$service->service_type}, Active: " . ($service->is_active ? 'Yes' : 'No'));
        }
        
        return 0;
    }
}
