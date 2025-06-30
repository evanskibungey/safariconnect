<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.transportation.pricing.index') }}" 
                   class="text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Pricing Rule Details
                    </h2>
                    <p class="text-gray-600 mt-1">{{ $pricing->transportationService->name }} pricing configuration</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.transportation.pricing.edit', $pricing) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Pricing
                </a>
                
                <form action="{{ route('admin.transportation.pricing.duplicate', $pricing) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-copy mr-2"></i>Duplicate
                    </button>
                </form>
                
                <form action="{{ route('admin.transportation.pricing.toggle', $pricing) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $pricing->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-{{ $pricing->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $pricing->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Pricing Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing Overview</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Service Info -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r 
                                    @if($pricing->transportationService->service_type === 'shared_ride') from-green-400 to-green-600 
                                    @elseif($pricing->transportationService->service_type === 'solo_ride') from-blue-400 to-blue-600
                                    @elseif($pricing->transportationService->service_type === 'airport_transfer') from-purple-400 to-purple-600
                                    @elseif($pricing->transportationService->service_type === 'car_hire') from-orange-400 to-orange-600
                                    @else from-pink-400 to-pink-600 @endif
                                    flex items-center justify-center">
                                    <i class="fas fa-
                                        @if($pricing->transportationService->service_type === 'shared_ride') users
                                        @elseif($pricing->transportationService->service_type === 'solo_ride') car
                                        @elseif($pricing->transportationService->service_type === 'airport_transfer') plane
                                        @elseif($pricing->transportationService->service_type === 'car_hire') calendar
                                        @else box @endif
                                        text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Service</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $pricing->transportationService->name }}</div>
                                <div class="text-sm text-gray-500">{{ $pricing->transportationService->service_type_name }}</div>
                            </div>
                        </div>

                        <!-- Base Price -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Base Price</div>
                            <div class="text-2xl font-bold text-gray-900">KSh {{ number_format($pricing->base_price, 2) }}</div>
                        </div>

                        <!-- Route Info -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Route</div>
                            <div class="text-lg font-semibold text-gray-900">
                                @if($pricing->pickupCity && $pricing->dropoffCity)
                                    {{ $pricing->pickupCity->name }} → {{ $pricing->dropoffCity->name }}
                                @elseif($pricing->pickupCity)
                                    From {{ $pricing->pickupCity->name }}
                                @elseif($pricing->dropoffCity)
                                    To {{ $pricing->dropoffCity->name }}
                                @else
                                    General Pricing
                                @endif
                            </div>
                            @if($pricing->distance_km)
                                <div class="text-sm text-gray-500">{{ $pricing->distance_km }} km</div>
                            @endif
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $pricing->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $pricing->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle/Transfer Details -->
                @if($pricing->vehicleType || $pricing->transfer_type || $pricing->parcel_type)
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Service Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @if($pricing->vehicleType)
                        <div>
                            <div class="text-sm font-medium text-gray-500">Vehicle Type</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $pricing->vehicleType->name }}</div>
                            <div class="text-sm text-gray-500">{{ $pricing->vehicleType->capacity }} seater capacity</div>
                        </div>
                        @endif

                        @if($pricing->transfer_type)
                        <div>
                            <div class="text-sm font-medium text-gray-500">Transfer Type</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $pricing->transfer_type_name }}</div>
                        </div>
                        @endif

                        @if($pricing->parcel_type)
                        <div>
                            <div class="text-sm font-medium text-gray-500">Parcel Type</div>
                            <div class="text-lg font-semibold text-gray-900">{{ $pricing->parcel_type_name }}</div>
                            @if($pricing->weight_limit)
                                <div class="text-sm text-gray-500">Max {{ $pricing->weight_limit }} kg</div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Pricing Breakdown -->
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Pricing Breakdown</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Base Pricing -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h5 class="font-medium text-blue-900 mb-2">Base Pricing</h5>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-blue-700">Base Price:</span>
                                    <span class="font-semibold text-blue-900">KSh {{ number_format($pricing->base_price, 2) }}</span>
                                </div>
                                @if($pricing->price_per_km)
                                <div class="flex justify-between">
                                    <span class="text-blue-700">Per Kilometer:</span>
                                    <span class="font-semibold text-blue-900">KSh {{ number_format($pricing->price_per_km, 2) }}</span>
                                </div>
                                @endif
                                @if($pricing->price_per_day)
                                <div class="flex justify-between">
                                    <span class="text-blue-700">Per Day:</span>
                                    <span class="font-semibold text-blue-900">KSh {{ number_format($pricing->price_per_day, 2) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Airport Surcharges -->
                        @if($pricing->airport_pickup_surcharge > 0 || $pricing->airport_dropoff_surcharge > 0)
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h5 class="font-medium text-purple-900 mb-2">Airport Surcharges</h5>
                            <div class="space-y-2">
                                @if($pricing->airport_pickup_surcharge > 0)
                                <div class="flex justify-between">
                                    <span class="text-purple-700">Pickup Surcharge:</span>
                                    <span class="font-semibold text-purple-900">KSh {{ number_format($pricing->airport_pickup_surcharge, 2) }}</span>
                                </div>
                                @endif
                                @if($pricing->airport_dropoff_surcharge > 0)
                                <div class="flex justify-between">
                                    <span class="text-purple-700">Dropoff Surcharge:</span>
                                    <span class="font-semibold text-purple-900">KSh {{ number_format($pricing->airport_dropoff_surcharge, 2) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Time-based Surcharges -->
                        @if($pricing->weekend_surcharge_percentage > 0 || $pricing->night_surcharge_percentage > 0)
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h5 class="font-medium text-orange-900 mb-2">Time-based Surcharges</h5>
                            <div class="space-y-2">
                                @if($pricing->weekend_surcharge_percentage > 0)
                                <div class="flex justify-between">
                                    <span class="text-orange-700">Weekend:</span>
                                    <span class="font-semibold text-orange-900">+{{ $pricing->weekend_surcharge_percentage }}%</span>
                                </div>
                                @endif
                                @if($pricing->night_surcharge_percentage > 0)
                                <div class="flex justify-between">
                                    <span class="text-orange-700">Night Time:</span>
                                    <span class="font-semibold text-orange-900">+{{ $pricing->night_surcharge_percentage }}%</span>
                                </div>
                                <div class="text-xs text-orange-600">
                                    {{ $pricing->night_start_time->format('H:i') }} - {{ $pricing->night_end_time->format('H:i') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Price Calculator Example -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Price Calculator Example</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Normal Price -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Normal Rate</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Base Price:</span>
                                    <span class="font-semibold">KSh {{ number_format($pricing->base_price, 2) }}</span>
                                </div>
                                @if($pricing->airport_pickup_surcharge > 0 && $pricing->transfer_type === 'pickup')
                                <div class="flex justify-between text-blue-600">
                                    <span>Airport Pickup:</span>
                                    <span>+KSh {{ number_format($pricing->airport_pickup_surcharge, 2) }}</span>
                                </div>
                                @endif
                                @if($pricing->airport_dropoff_surcharge > 0 && $pricing->transfer_type === 'dropoff')
                                <div class="flex justify-between text-blue-600">
                                    <span>Airport Dropoff:</span>
                                    <span>+KSh {{ number_format($pricing->airport_dropoff_surcharge, 2) }}</span>
                                </div>
                                @endif
                                <div class="border-t pt-2 flex justify-between font-bold">
                                    <span>Total:</span>
                                    <span>KSh {{ number_format($pricing->calculateTotalPrice(), 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Weekend/Night Price -->
                        @if($pricing->weekend_surcharge_percentage > 0 || $pricing->night_surcharge_percentage > 0)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">
                                @if($pricing->weekend_surcharge_percentage > 0 && $pricing->night_surcharge_percentage > 0)
                                    Weekend Night Rate
                                @elseif($pricing->weekend_surcharge_percentage > 0)
                                    Weekend Rate
                                @else
                                    Night Rate
                                @endif
                            </h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Base Price:</span>
                                    <span>KSh {{ number_format($pricing->base_price, 2) }}</span>
                                </div>
                                @if($pricing->weekend_surcharge_percentage > 0)
                                <div class="flex justify-between text-purple-600">
                                    <span>Weekend (+{{ $pricing->weekend_surcharge_percentage }}%):</span>
                                    <span>+KSh {{ number_format($pricing->base_price * $pricing->weekend_surcharge_percentage / 100, 2) }}</span>
                                </div>
                                @endif
                                @if($pricing->night_surcharge_percentage > 0)
                                <div class="flex justify-between text-orange-600">
                                    <span>Night (+{{ $pricing->night_surcharge_percentage }}%):</span>
                                    <span>+KSh {{ number_format($pricing->base_price * $pricing->night_surcharge_percentage / 100, 2) }}</span>
                                </div>
                                @endif
                                <div class="border-t pt-2 flex justify-between font-bold">
                                    <span>Total:</span>
                                    <span>KSh {{ number_format($pricing->calculateTotalPrice(null, true), 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pricing Rule Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Rule Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $pricing->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $pricing->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Rule ID</div>
                            <div class="text-sm text-gray-900 font-mono">{{ $pricing->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>
