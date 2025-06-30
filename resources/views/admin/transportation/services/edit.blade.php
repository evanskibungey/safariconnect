<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.transportation.services.index') }}" 
               class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Transportation Service') }}
                </h2>
                <p class="text-gray-600 mt-1">Update the service details below</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.transportation.services.update', $service) }}" method="POST" class="p-6 space-y-6" x-data="serviceForm()">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Service Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $service->name) }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="e.g., Premium Airport Transfer">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Service Type <span class="text-red-500">*</span>
                        </label>
                        <select id="service_type" 
                                name="service_type" 
                                required
                                x-model="serviceType"
                                @change="updatePricingModel()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('service_type') border-red-500 @enderror">
                            <option value="">Select Service Type</option>
                            <option value="shared_ride" {{ old('service_type', $service->service_type) === 'shared_ride' ? 'selected' : '' }}>
                                Shared Ride
                            </option>
                            <option value="solo_ride" {{ old('service_type', $service->service_type) === 'solo_ride' ? 'selected' : '' }}>
                                Solo Ride
                            </option>
                            <option value="airport_transfer" {{ old('service_type', $service->service_type) === 'airport_transfer' ? 'selected' : '' }}>
                                Airport Transfer
                            </option>
                            <option value="car_hire" {{ old('service_type', $service->service_type) === 'car_hire' ? 'selected' : '' }}>
                                Car Hire
                            </option>
                            <option value="parcel_delivery" {{ old('service_type', $service->service_type) === 'parcel_delivery' ? 'selected' : '' }}>
                                Parcel Delivery
                            </option>
                        </select>
                        @error('service_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Service Type Info -->
                        <div x-show="serviceType" class="mt-2 p-3 bg-blue-50 rounded-lg text-sm text-blue-800">
                            <div x-show="serviceType === 'shared_ride'">
                                <strong>Shared Ride:</strong> Multiple passengers share the cost of transportation between cities.
                            </div>
                            <div x-show="serviceType === 'solo_ride'">
                                <strong>Solo Ride:</strong> Private ride for individual or group with vehicle type selection.
                            </div>
                            <div x-show="serviceType === 'airport_transfer'">
                                <strong>Airport Transfer:</strong> Dedicated airport pickup/dropoff service with surcharges.
                            </div>
                            <div x-show="serviceType === 'car_hire'">
                                <strong>Car Hire:</strong> Vehicle rental service charged per day.
                            </div>
                            <div x-show="serviceType === 'parcel_delivery'">
                                <strong>Parcel Delivery:</strong> Package delivery service based on size and weight.
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Model -->
                    <div>
                        <label for="pricing_model" class="block text-sm font-medium text-gray-700 mb-2">
                            Pricing Model <span class="text-red-500">*</span>
                        </label>
                        <select id="pricing_model" 
                                name="pricing_model" 
                                required
                                x-model="pricingModel"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pricing_model') border-red-500 @enderror">
                            <option value="">Select Pricing Model</option>
                            <option value="city_based" {{ old('pricing_model', $service->pricing_model) === 'city_based' ? 'selected' : '' }}>
                                City Based
                            </option>
                            <option value="vehicle_city_based" {{ old('pricing_model', $service->pricing_model) === 'vehicle_city_based' ? 'selected' : '' }}>
                                Vehicle & City Based
                            </option>
                            <option value="vehicle_transfer_based" {{ old('pricing_model', $service->pricing_model) === 'vehicle_transfer_based' ? 'selected' : '' }}>
                                Vehicle & Transfer Based
                            </option>
                            <option value="time_based" {{ old('pricing_model', $service->pricing_model) === 'time_based' ? 'selected' : '' }}>
                                Time Based
                            </option>
                            <option value="weight_location_based" {{ old('pricing_model', $service->pricing_model) === 'weight_location_based' ? 'selected' : '' }}>
                                Weight & Location Based
                            </option>
                        </select>
                        @error('pricing_model')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Describe this transportation service...">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Service Features
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            @php
                                $availableFeatures = [
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
                                ];
                                $selectedFeatures = old('features', $service->features ?? []);
                            @endphp
                            @foreach($availableFeatures as $key => $label)
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="features[]" 
                                           value="{{ $key }}"
                                           {{ in_array($key, $selectedFeatures) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active Service</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active services will be available for booking</p>
                    </div>

                    <!-- Pricing Rules Info -->
                    @if($service->servicePricing->count() > 0)
                    <div class="border-t pt-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Pricing Rules Notice
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>This service has {{ $service->servicePricing->count() }} pricing rule(s). Changing the service type or pricing model may affect existing pricing rules.</p>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.transportation.pricing.index', ['service_id' => $service->id]) }}" 
                                               class="text-yellow-800 underline hover:text-yellow-900">
                                                View pricing rules →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.transportation.services.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                            Update Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function serviceForm() {
            return {
                serviceType: '{{ old('service_type', $service->service_type) }}',
                pricingModel: '{{ old('pricing_model', $service->pricing_model) }}',
                
                init() {
                    // Initialize with current values
                },

                updatePricingModel() {
                    // Don't auto-change pricing model when editing
                    // User should manually select if they want to change
                }
            }
        }
    </script>
</x-admin.layouts.app>
