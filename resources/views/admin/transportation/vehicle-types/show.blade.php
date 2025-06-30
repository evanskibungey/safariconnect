<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                   class="text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $vehicleType->name }}
                    </h2>
                    <p class="text-gray-600 mt-1">Vehicle type details and pricing rules</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.transportation.vehicle-types.edit', $vehicleType) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Vehicle Type
                </a>
                
                <form action="{{ route('admin.transportation.vehicle-types.toggle', $vehicleType) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $vehicleType->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-{{ $vehicleType->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $vehicleType->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Vehicle Type Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Type Overview</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Vehicle Icon & Info -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center">
                                    <i class="fas fa-car text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Vehicle Type</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $vehicleType->name }}</div>
                            </div>
                        </div>

                        <!-- Capacity -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Seating Capacity</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $vehicleType->capacity }}</div>
                            <div class="text-sm text-gray-500">passengers</div>
                        </div>

                        <!-- Base Rate -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Base Rate</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $vehicleType->formatted_base_rate }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $vehicleType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $vehicleType->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($vehicleType->description)
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                    <p class="text-gray-700">{{ $vehicleType->description }}</p>
                </div>
                @endif
            </div>

            <!-- Pricing Rules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Pricing Rules Using This Vehicle Type</h3>
                        @if($vehicleType->servicePricing->count() > 0)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $vehicleType->servicePricing->count() }} active rules
                            </span>
                        @endif
                    </div>
                </div>

                @if($vehicleType->servicePricing->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route/Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Additional Rates</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($vehicleType->servicePricing as $pricing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $pricing->transportationService->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $pricing->transportationService->service_type_name }}</div>
                                </td>
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
                        <p class="text-gray-500 mb-4">This vehicle type is not used in any pricing rules yet</p>
                        <a href="{{ route('admin.transportation.pricing.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Create Pricing Rule
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Vehicle Type Usage Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Usage Statistics</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Service Types Using This Vehicle -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Service Types</h4>
                            @php
                                $serviceTypes = $vehicleType->servicePricing->pluck('transportationService.service_type')->unique();
                            @endphp
                            @if($serviceTypes->count() > 0)
                                <div class="space-y-2">
                                    @foreach($serviceTypes as $serviceType)
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-check text-green-500 mr-2"></i>
                                            {{ ucfirst(str_replace('_', ' ', $serviceType)) }}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Not used in any services</p>
                            @endif
                        </div>

                        <!-- Active vs Inactive Rules -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Rule Status</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Active Rules:</span>
                                    <span class="font-semibold text-green-600">{{ $vehicleType->servicePricing->where('is_active', true)->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Inactive Rules:</span>
                                    <span class="font-semibold text-red-600">{{ $vehicleType->servicePricing->where('is_active', false)->count() }}</span>
                                </div>
                                <div class="flex justify-between text-sm font-medium border-t pt-2">
                                    <span class="text-gray-900">Total Rules:</span>
                                    <span class="text-gray-900">{{ $vehicleType->servicePricing->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Quick Actions</h4>
                            <div class="space-y-2">
                                <a href="{{ route('admin.transportation.pricing.create') }}?vehicle_type_id={{ $vehicleType->id }}" 
                                   class="block text-sm text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-plus mr-2"></i>Add Pricing Rule
                                </a>
                                @if($vehicleType->servicePricing->count() > 0)
                                    <a href="{{ route('admin.transportation.pricing.index') }}?vehicle_type_id={{ $vehicleType->id }}" 
                                       class="block text-sm text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-filter mr-2"></i>View All Rules
                                    </a>
                                @endif
                                <a href="{{ route('admin.transportation.vehicle-types.edit', $vehicleType) }}" 
                                   class="block text-sm text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit mr-2"></i>Edit Vehicle Type
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Type Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Type Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $vehicleType->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $vehicleType->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Vehicle Type ID</div>
                            <div class="text-sm text-gray-900 font-mono">{{ $vehicleType->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>
