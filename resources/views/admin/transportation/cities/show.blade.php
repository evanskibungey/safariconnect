<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.transportation.cities.index') }}" 
                   class="text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $city->name }}
                    </h2>
                    <p class="text-gray-600 mt-1">City details and pricing rules</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.transportation.cities.edit', $city) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit City
                </a>
                
                <form action="{{ route('admin.transportation.cities.toggle', $city) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $city->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-{{ $city->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $city->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- City Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">City Overview</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- City Icon & Info -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">City</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $city->name }}</div>
                                <div class="text-sm text-gray-500">
                                    @if($city->state)
                                        {{ $city->state }}, 
                                    @endif
                                    {{ $city->country }}
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $city->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $city->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <!-- Pickup Rules Count -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Pickup Rules</div>
                            <div class="flex items-center mt-1">
                                <span class="text-lg font-semibold text-gray-900">{{ $city->pickupPricing->count() }}</span>
                                @if($city->pickupPricing->count() > 0)
                                    <a href="{{ route('admin.transportation.pricing.index', ['pickup_city_id' => $city->id]) }}" 
                                       class="ml-2 text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Dropoff Rules Count -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Dropoff Rules</div>
                            <div class="flex items-center mt-1">
                                <span class="text-lg font-semibold text-gray-900">{{ $city->dropoffPricing->count() }}</span>
                                @if($city->dropoffPricing->count() > 0)
                                    <a href="{{ route('admin.transportation.pricing.index', ['dropoff_city_id' => $city->id]) }}" 
                                       class="ml-2 text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pickup Pricing Rules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Pickup Location Pricing Rules</h3>
                        <a href="{{ route('admin.transportation.pricing.create', ['pickup_city_id' => $city->id]) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Add Pickup Rule
                        </a>
                    </div>
                </div>

                @if($city->pickupPricing->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($city->pickupPricing as $pricing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $pricing->transportationService->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $pricing->transportationService->service_type_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($pricing->dropoffCity)
                                            {{ $pricing->dropoffCity->name }}
                                            @if($pricing->distance_km)
                                                <span class="text-gray-500">({{ $pricing->distance_km }}km)</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Any destination</span>
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
                        <i class="fas fa-route text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-900 mb-2">No pickup pricing rules</p>
                        <p class="text-gray-500 mb-4">Add pricing rules that start from this city</p>
                        <a href="{{ route('admin.transportation.pricing.create', ['pickup_city_id' => $city->id]) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add Pickup Rule
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Dropoff Pricing Rules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Dropoff Location Pricing Rules</h3>
                        <a href="{{ route('admin.transportation.pricing.create', ['dropoff_city_id' => $city->id]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center text-sm transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Add Dropoff Rule
                        </a>
                    </div>
                </div>

                @if($city->dropoffPricing->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($city->dropoffPricing as $pricing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $pricing->transportationService->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $pricing->transportationService->service_type_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($pricing->pickupCity)
                                            {{ $pricing->pickupCity->name }}
                                            @if($pricing->distance_km)
                                                <span class="text-gray-500">({{ $pricing->distance_km }}km)</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Any origin</span>
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
                        <i class="fas fa-map-marker-alt text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-900 mb-2">No dropoff pricing rules</p>
                        <p class="text-gray-500 mb-4">Add pricing rules that end at this city</p>
                        <a href="{{ route('admin.transportation.pricing.create', ['dropoff_city_id' => $city->id]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>Add Dropoff Rule
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- City Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">City Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $city->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $city->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">City ID</div>
                            <div class="text-sm text-gray-900 font-mono">{{ $city->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>
