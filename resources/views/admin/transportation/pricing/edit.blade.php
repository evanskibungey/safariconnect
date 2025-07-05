<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.transportation.pricing.index') }}" 
               class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Pricing Rule') }}
                </h2>
                <p class="text-gray-600 mt-1">Update the pricing rule details below</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.transportation.pricing.update', $pricing) }}" method="POST" class="p-6 space-y-6" x-data="pricingForm()">
                    @csrf
                    @method('PUT')

                    <!-- Service Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transportation_service_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Transportation Service <span class="text-red-500">*</span>
                            </label>
                            <select id="transportation_service_id" 
                                    name="transportation_service_id" 
                                    required
                                    x-model="selectedService"
                                    @change="updateServiceType()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transportation_service_id') border-red-500 @enderror">
                                <option value="">Select Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" 
                                            data-type="{{ $service->service_type }}"
                                            {{ old('transportation_service_id', $pricing->transportation_service_id) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ $service->service_type_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('transportation_service_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Base Price (KSh) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="base_price" 
                                   name="base_price" 
                                   value="{{ old('base_price', $pricing->base_price) }}" 
                                   required
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('base_price') border-red-500 @enderror"
                                   placeholder="0.00">
                            @error('base_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Airport Transfer Specific Configuration -->
                    <div x-show="serviceType === 'airport_transfer'" class="space-y-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-blue-900 mb-2">
                                <i class="fas fa-plane mr-2"></i>Airport Transfer Configuration
                            </h3>
                            <p class="text-sm text-blue-700">
                                Configure airport transfer pricing. First select the transfer type (pickup or drop-off), 
                                then choose the relevant airport and city.
                            </p>
                        </div>

                        <!-- Step 1: Transfer Type Selection -->
                        <div>
                            <label for="transfer_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Transfer Type <span class="text-red-500">*</span>
                            </label>
                            <select id="transfer_type" 
                                    name="transfer_type" 
                                    x-model="transferType"
                                    @change="resetAirportFields()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transfer_type') border-red-500 @enderror">
                                <option value="">Select Transfer Type</option>
                                <option value="pickup" {{ old('transfer_type', $pricing->transfer_type) === 'pickup' ? 'selected' : '' }}>
                                    Airport Pickup (Airport → City)
                                </option>
                                <option value="dropoff" {{ old('transfer_type', $pricing->transfer_type) === 'dropoff' ? 'selected' : '' }}>
                                    Airport Drop-off (City → Airport)
                                </option>
                            </select>
                            @error('transfer_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Step 2: Airport & City Selection for Pickup -->
                        <div x-show="transferType === 'pickup'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="pickup_airport_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pickup Airport <span class="text-red-500">*</span>
                                </label>
                                <select id="pickup_airport_id" 
                                        name="pickup_airport_id" 
                                        x-model="selectedPickupAirport"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pickup_airport_id') border-red-500 @enderror">
                                    <option value="">Select Pickup Airport</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('pickup_airport_id', $pricing->pickup_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->full_name }} - {{ $airport->city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pickup_airport_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dropoff_city_id_pickup" class="block text-sm font-medium text-gray-700 mb-2">
                                    Destination City <span class="text-red-500">*</span>
                                </label>
                                <select id="dropoff_city_id_pickup" 
                                        name="dropoff_city_id" 
                                        x-model="selectedDropoffCity"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dropoff_city_id') border-red-500 @enderror">
                                    <option value="">Select Destination City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('dropoff_city_id', $pricing->dropoff_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dropoff_city_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Step 2: City & Airport Selection for Drop-off -->
                        <div x-show="transferType === 'dropoff'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="pickup_city_id_dropoff" class="block text-sm font-medium text-gray-700 mb-2">
                                    Origin City <span class="text-red-500">*</span>
                                </label>
                                <select id="pickup_city_id_dropoff" 
                                        name="pickup_city_id" 
                                        x-model="selectedPickupCity"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pickup_city_id') border-red-500 @enderror">
                                    <option value="">Select Origin City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('pickup_city_id', $pricing->pickup_city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pickup_city_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="dropoff_airport_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Drop-off Airport <span class="text-red-500">*</span>
                                </label>
                                <select id="dropoff_airport_id" 
                                        name="dropoff_airport_id" 
                                        x-model="selectedDropoffAirport"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dropoff_airport_id') border-red-500 @enderror">
                                    <option value="">Select Drop-off Airport</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('dropoff_airport_id', $pricing->dropoff_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->full_name }} - {{ $airport->city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dropoff_airport_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Airport Transfer Surcharges -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="airport_pickup_surcharge" class="block text-sm font-medium text-gray-700 mb-2">
                                    Airport Pickup Surcharge (KSh)
                                </label>
                                <input type="number" 
                                       id="airport_pickup_surcharge" 
                                       name="airport_pickup_surcharge" 
                                       value="{{ old('airport_pickup_surcharge', $pricing->airport_pickup_surcharge) }}" 
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('airport_pickup_surcharge') border-red-500 @enderror">
                                @error('airport_pickup_surcharge')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="airport_dropoff_surcharge" class="block text-sm font-medium text-gray-700 mb-2">
                                    Airport Dropoff Surcharge (KSh)
                                </label>
                                <input type="number" 
                                       id="airport_dropoff_surcharge" 
                                       name="airport_dropoff_surcharge" 
                                       value="{{ old('airport_dropoff_surcharge', $pricing->airport_dropoff_surcharge) }}" 
                                       step="0.01"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('airport_dropoff_surcharge') border-red-500 @enderror">
                                @error('airport_dropoff_surcharge')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Regular Route Selection (for non-airport services) -->
                    <div x-show="needsRoute && serviceType !== 'airport_transfer'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="pickup_city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pickup City
                            </label>
                            <select id="pickup_city_id" 
                                    name="pickup_city_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pickup_city_id') border-red-500 @enderror">
                                <option value="">Select Pickup City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('pickup_city_id', $pricing->pickup_city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pickup_city_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dropoff_city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Dropoff City
                            </label>
                            <select id="dropoff_city_id" 
                                    name="dropoff_city_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('dropoff_city_id') border-red-500 @enderror">
                                <option value="">Select Dropoff City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('dropoff_city_id', $pricing->dropoff_city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dropoff_city_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="distance_km" class="block text-sm font-medium text-gray-700 mb-2">
                                Distance (km)
                            </label>
                            <input type="number" 
                                   id="distance_km" 
                                   name="distance_km" 
                                   value="{{ old('distance_km', $pricing->distance_km) }}" 
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('distance_km') border-red-500 @enderror"
                                   placeholder="Optional">
                            @error('distance_km')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Vehicle Type (for relevant services) -->
                    <div x-show="needsVehicleType">
                        <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Vehicle Type <span x-show="serviceType === 'airport_transfer'" class="text-red-500">*</span>
                        </label>
                        <select id="vehicle_type_id" 
                                name="vehicle_type_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('vehicle_type_id') border-red-500 @enderror">
                            <option value="">Select Vehicle Type</option>
                            @foreach($vehicleTypes as $vehicleType)
                                <option value="{{ $vehicleType->id }}" {{ old('vehicle_type_id', $pricing->vehicle_type_id) == $vehicleType->id ? 'selected' : '' }}>
                                    {{ $vehicleType->name }} ({{ $vehicleType->capacity }} seater)
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle_type_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parcel Delivery Specific Fields -->
                    <div x-show="serviceType === 'parcel_delivery'" class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Parcel Delivery Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="parcel_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Parcel Type
                                </label>
                                <select id="parcel_type" 
                                        name="parcel_type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('parcel_type') border-red-500 @enderror">
                                    <option value="">Select Parcel Type</option>
                                    <option value="documents" {{ old('parcel_type', $pricing->parcel_type) === 'documents' ? 'selected' : '' }}>
                                        Documents
                                    </option>
                                    <option value="small" {{ old('parcel_type', $pricing->parcel_type) === 'small' ? 'selected' : '' }}>
                                        Small Package
                                    </option>
                                    <option value="medium" {{ old('parcel_type', $pricing->parcel_type) === 'medium' ? 'selected' : '' }}>
                                        Medium Package
                                    </option>
                                    <option value="large" {{ old('parcel_type', $pricing->parcel_type) === 'large' ? 'selected' : '' }}>
                                        Large Package
                                    </option>
                                </select>
                                @error('parcel_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="weight_limit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Weight Limit (kg)
                                </label>
                                <input type="number" 
                                       id="weight_limit" 
                                       name="weight_limit" 
                                       value="{{ old('weight_limit', $pricing->weight_limit) }}" 
                                       step="0.1"
                                       min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('weight_limit') border-red-500 @enderror"
                                       placeholder="Optional">
                                @error('weight_limit')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Pricing Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price_per_km" class="block text-sm font-medium text-gray-700 mb-2">
                                Price per Kilometer (KSh)
                            </label>
                            <input type="number" 
                                   id="price_per_km" 
                                   name="price_per_km" 
                                   value="{{ old('price_per_km', $pricing->price_per_km) }}" 
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price_per_km') border-red-500 @enderror"
                                   placeholder="Optional">
                            @error('price_per_km')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-show="serviceType === 'car_hire'">
                            <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-2">
                                Price per Day (KSh)
                            </label>
                            <input type="number" 
                                   id="price_per_day" 
                                   name="price_per_day" 
                                   value="{{ old('price_per_day', $pricing->price_per_day) }}" 
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price_per_day') border-red-500 @enderror"
                                   placeholder="For car hire service">
                            @error('price_per_day')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Surcharges -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Surcharges & Additional Fees</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="weekend_surcharge_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                    Weekend Surcharge (%)
                                </label>
                                <input type="number" 
                                       id="weekend_surcharge_percentage" 
                                       name="weekend_surcharge_percentage" 
                                       value="{{ old('weekend_surcharge_percentage', $pricing->weekend_surcharge_percentage) }}" 
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('weekend_surcharge_percentage') border-red-500 @enderror">
                                @error('weekend_surcharge_percentage')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="night_surcharge_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                                    Night Surcharge (%)
                                </label>
                                <input type="number" 
                                       id="night_surcharge_percentage" 
                                       name="night_surcharge_percentage" 
                                       value="{{ old('night_surcharge_percentage', $pricing->night_surcharge_percentage) }}" 
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('night_surcharge_percentage') border-red-500 @enderror">
                                @error('night_surcharge_percentage')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="night_start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Night Time Start
                                </label>
                                <input type="time" 
                                       id="night_start_time" 
                                       name="night_start_time" 
                                       value="{{ old('night_start_time', $pricing->night_start_time ? $pricing->night_start_time->format('H:i') : '22:00') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('night_start_time') border-red-500 @enderror">
                                @error('night_start_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="night_end_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Night Time End
                                </label>
                                <input type="time" 
                                       id="night_end_time" 
                                       name="night_end_time" 
                                       value="{{ old('night_end_time', $pricing->night_end_time ? $pricing->night_end_time->format('H:i') : '06:00') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('night_end_time') border-red-500 @enderror">
                                @error('night_end_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="border-t pt-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $pricing->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active Pricing Rule</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active pricing rules will be used for calculations</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.transportation.pricing.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                            Update Pricing Rule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function pricingForm() {
            return {
                selectedService: '{{ old('transportation_service_id', $pricing->transportation_service_id) }}',
                serviceType: '{{ $pricing->transportationService->service_type }}',
                transferType: '{{ old('transfer_type', $pricing->transfer_type) }}',
                selectedPickupAirport: '{{ old('pickup_airport_id', $pricing->pickup_airport_id) }}',
                selectedDropoffAirport: '{{ old('dropoff_airport_id', $pricing->dropoff_airport_id) }}',
                selectedPickupCity: '{{ old('pickup_city_id', $pricing->pickup_city_id) }}',
                selectedDropoffCity: '{{ old('dropoff_city_id', $pricing->dropoff_city_id) }}',
                needsRoute: false,
                needsVehicleType: false,

                init() {
                    console.log('Edit form initialized with:', {
                        serviceType: this.serviceType,
                        transferType: this.transferType
                    });
                    this.updateServiceType();
                    // Ensure form fields are properly enabled/disabled on init
                    this.$nextTick(() => {
                        this.updateFieldStates();
                    });
                },

                updateServiceType() {
                    const select = document.getElementById('transportation_service_id');
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.dataset.type) {
                        this.serviceType = selectedOption.dataset.type;
                        this.needsRoute = ['shared_ride', 'solo_ride', 'parcel_delivery'].includes(this.serviceType);
                        this.needsVehicleType = ['solo_ride', 'airport_transfer', 'car_hire'].includes(this.serviceType);
                    }
                },

                resetAirportFields() {
                    this.selectedPickupAirport = '';
                    this.selectedDropoffAirport = '';
                    this.selectedPickupCity = '';
                    this.selectedDropoffCity = '';
                },

                updateFieldStates() {
                    // This function ensures fields are properly enabled/disabled based on the current state
                    if (this.serviceType === 'airport_transfer') {
                        // Disable regular route fields
                        const pickupCity = document.getElementById('pickup_city_id');
                        const dropoffCity = document.getElementById('dropoff_city_id');
                        if (pickupCity) pickupCity.disabled = true;
                        if (dropoffCity) dropoffCity.disabled = true;

                        // Enable/disable airport fields based on transfer type
                        if (this.transferType === 'pickup') {
                            // Enable pickup fields
                            const pickupAirport = document.getElementById('pickup_airport_id');
                            const dropoffCityPickup = document.getElementById('dropoff_city_id_pickup');
                            if (pickupAirport) pickupAirport.disabled = false;
                            if (dropoffCityPickup) dropoffCityPickup.disabled = false;

                            // Disable dropoff fields
                            const pickupCityDropoff = document.getElementById('pickup_city_id_dropoff');
                            const dropoffAirport = document.getElementById('dropoff_airport_id');
                            if (pickupCityDropoff) pickupCityDropoff.disabled = true;
                            if (dropoffAirport) dropoffAirport.disabled = true;
                        } else if (this.transferType === 'dropoff') {
                            // Enable dropoff fields
                            const pickupCityDropoff = document.getElementById('pickup_city_id_dropoff');
                            const dropoffAirport = document.getElementById('dropoff_airport_id');
                            if (pickupCityDropoff) pickupCityDropoff.disabled = false;
                            if (dropoffAirport) dropoffAirport.disabled = false;

                            // Disable pickup fields
                            const pickupAirport = document.getElementById('pickup_airport_id');
                            const dropoffCityPickup = document.getElementById('dropoff_city_id_pickup');
                            if (pickupAirport) pickupAirport.disabled = true;
                            if (dropoffCityPickup) dropoffCityPickup.disabled = true;
                        }
                    } else {
                        // Enable regular route fields
                        const pickupCity = document.getElementById('pickup_city_id');
                        const dropoffCity = document.getElementById('dropoff_city_id');
                        if (pickupCity) pickupCity.disabled = false;
                        if (dropoffCity) dropoffCity.disabled = false;

                        // Disable all airport fields
                        const airportFields = [
                            'pickup_airport_id',
                            'dropoff_airport_id',
                            'pickup_city_id_dropoff',
                            'dropoff_city_id_pickup'
                        ];
                        airportFields.forEach(fieldId => {
                            const field = document.getElementById(fieldId);
                            if (field) field.disabled = true;
                        });
                    }
                }
            }
        }
    </script>

    <style>
    [x-cloak] {
        display: none !important;
    }
    </style>
</x-admin.layouts.app>
