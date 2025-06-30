<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.transportation.services.index') }}" 
                   class="text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $service->name }}
                    </h2>
                    <p class="text-gray-600 mt-1">Transportation service details</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.transportation.services.edit', $service) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Service
                </a>
                
                <form action="{{ route('admin.transportation.services.toggle', $service) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $service->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-{{ $service->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Service Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Service Overview</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Service Icon & Type -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r 
                                    @if($service->service_type === 'shared_ride') from-green-400 to-green-600 
                                    @elseif($service->service_type === 'solo_ride') from-blue-400 to-blue-600
                                    @elseif($service->service_type === 'airport_transfer') from-purple-400 to-purple-600
                                    @elseif($service->service_type === 'car_hire') from-orange-400 to-orange-600
                                    @else from-pink-400 to-pink-600 @endif
                                    flex items-center justify-center">
                                    <i class="fas fa-
                                        @if($service->service_type === 'shared_ride') users
                                        @elseif($service->service_type === 'solo_ride') car
                                        @elseif($service->service_type === 'airport_transfer') plane
                                        @elseif($service->service_type === 'car_hire') calendar
                                        @else box @endif
                                        text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Service Type</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $service->service_type_name }}</div>
                            </div>
                        </div>

                        <!-- Pricing Model -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Pricing Model</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $service->pricing_model_name }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <!-- Pricing Rules Count -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Pricing Rules</div>
                            <div class="flex items-center mt-1">
                                <span class="text-lg font-semibold text-gray-900">{{ $service->servicePricing->count() }}</span>
                                @if($service->servicePricing->count() > 0)
                                    <a href="{{ route('admin.transportation.pricing.index', ['service_id' => $service->id]) }}" 
                                       class="ml-2 text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($service->description)
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                    <p class="text-gray-700">{{ $service->description }}</p>
                </div>
                @endif

                <!-- Features -->
                @if($service->features && count($service->features) > 0)
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Service Features</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($service->features as $feature)
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-sm text-gray-700">
                                    {{ 
                                        collect([
                                            'shared_cost' => 'Shared Cost',
                                            'eco_friendly' => 'Eco Friendly',
                                            'scheduled_departure' => 'Scheduled Departure',
                                            'private_vehicle' => 'Private Vehicle',
                                            'flexible_timing' => 'Flexible Timing',
                                            'door_to_door' => 'Door to Door',
                                            'flight_tracking' => 'Flight Tracking',
                                            'meet_and_greet' => 'Meet & Greet',
                                            'luggage_assistance' => 'Luggage Assistance',
                                            'self_drive' => 'Self Drive',
                                            'unlimited_mileage' => 'Unlimited Mileage',
                                            'same_day_delivery' => 'Same Day Delivery',
                                            'tracking' => 'Tracking',
                                            'insurance' => 'Insurance',
                                        ])->get($feature, ucfirst(str_replace('_', ' ', $feature)))
                                    }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Pricing Rules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Pricing Rules</h3>
                        <a href="{{ route('admin.transportation.pricing.create', ['service_id' => $service->id]) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Add Pricing Rule
                        </a>
                    </div>
                </div>

                @if($service->servicePricing->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route/Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Additional Rates</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($service->servicePricing as $pricing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($pricing->pickupCity && $pricing->dropoffCity)
                                            {{ $pricing->pickupCity->name }} → {{ $pricing->dropoffCity->name }}
                                            @if($pricing->distance_km)
                                                <span class="text-gray-500">({{ $pricing->distance_km }}km)</span>
                                            @endif
                                        @elseif($pricing->pickupCity)
                                            From {{ $pricing->pickupCity->name }}
                                        @elseif($pricing->dropoffCity)
                                            To {{ $pricing->dropoffCity->name }}
                                        @else
                                            General Pricing
                                        @endif
                                    </div>
                                    @if($pricing->transfer_type)
                                        <div class="text-sm text-gray-500">{{ $pricing->transfer_type_name }}</div>
                                    @endif
                                    @if($pricing->parcel_type)
                                        <div class="text-sm text-gray-500">{{ $pricing->parcel_type_name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pricing->vehicleType)
                                        <div class="text-sm font-medium text-gray-900">{{ $pricing->vehicleType->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $pricing->vehicleType->capacity }} seater</div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">KSh {{ number_format($pricing->base_price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs space-y-1">
                                        @if($pricing->price_per_km)
                                            <div>KSh {{ number_format($pricing->price_per_km, 2) }}/km</div>
                                        @endif
                                        @if($pricing->price_per_day)
                                            <div>KSh {{ number_format($pricing->price_per_day, 2) }}/day</div>
                                        @endif
                                        @if($pricing->airport_pickup_surcharge > 0)
                                            <div class="text-blue-600">+KSh {{ number_format($pricing->airport_pickup_surcharge, 2) }} pickup</div>
                                        @endif
                                        @if($pricing->airport_dropoff_surcharge > 0)
                                            <div class="text-blue-600">+KSh {{ number_format($pricing->airport_dropoff_surcharge, 2) }} dropoff</div>
                                        @endif
                                        @if($pricing->weekend_surcharge_percentage > 0)
                                            <div class="text-purple-600">+{{ $pricing->weekend_surcharge_percentage }}% weekend</div>
                                        @endif
                                        @if($pricing->night_surcharge_percentage > 0)
                                            <div class="text-orange-600">+{{ $pricing->night_surcharge_percentage }}% night</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $pricing->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pricing->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.transportation.pricing.show', $pricing) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.transportation.pricing.edit', $pricing) }}" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-6 text-center">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-900 mb-2">No pricing rules configured</p>
                        <p class="text-gray-500 mb-4">Add pricing rules to make this service bookable</p>
                        <a href="{{ route('admin.transportation.pricing.create', ['service_id' => $service->id]) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add First Pricing Rule
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Service Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Service Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $service->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $service->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Service ID</div>
                            <div class="text-sm text-gray-900 font-mono">{{ $service->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>
