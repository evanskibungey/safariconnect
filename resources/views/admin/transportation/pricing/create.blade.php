<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.transportation.pricing.index') }}"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Pricing
                </a>
                <div class="h-6 border-l border-gray-300"></div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create New Pricing Rule</h1>
                    <p class="text-sm text-gray-600 mt-1">Configure pricing for transportation services based on various
                        factors</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                    Step 1 of 1
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.transportation.pricing.store') }}" method="POST" class="space-y-8"
                x-data="pricingForm()" @submit="handleFormSubmit($event)">
                @csrf

                <!-- Service Configuration Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Service Configuration</h3>
                                <p class="text-sm text-gray-600">Select the transportation service and set the base
                                    pricing</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="transportation_service_id"
                                    class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Transportation Service
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="transportation_service_id" name="transportation_service_id" required
                                    x-model="selectedService" @change="updateServiceType()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('transportation_service_id') border-red-300 bg-red-50 @enderror">
                                    <option value="">Choose a service...</option>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-type="{{ $service->service_type }}"
                                        {{ old('transportation_service_id', request('service_id')) == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} ({{ $service->service_type_name }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('transportation_service_id')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="base_price" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    Base Price (KSh)
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="base_price" name="base_price"
                                        value="{{ old('base_price') }}" required step="0.01" min="0"
                                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('base_price') border-red-300 bg-red-50 @enderror"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">KSh</span>
                                    </div>
                                </div>
                                @error('base_price')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Airport Transfer Configuration -->
                <div x-show="serviceType === 'airport_transfer'" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Airport Transfer Configuration</h3>
                                    <p class="text-sm text-gray-600">Configure airport transfer pricing and route
                                        details</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Transfer Type Selection -->
                            <div class="space-y-3">
                                <label class="text-sm font-medium text-gray-700">Transfer Type <span
                                        class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative">
                                        <input type="radio" name="transfer_type" value="pickup" x-model="transferType"
                                            @change="resetAirportFields()" class="sr-only peer"
                                            {{ old('transfer_type') === 'pickup' ? 'checked' : '' }}>
                                        <div
                                            class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all duration-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Airport Pickup</div>
                                                    <div class="text-sm text-gray-500">Airport → City</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative">
                                        <input type="radio" name="transfer_type" value="dropoff" x-model="transferType"
                                            @change="resetAirportFields()" class="sr-only peer"
                                            {{ old('transfer_type') === 'dropoff' ? 'checked' : '' }}>
                                        <div
                                            class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all duration-200">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                    <svg class="w-4 h-4 text-green-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Airport Drop-off</div>
                                                    <div class="text-sm text-gray-500">City → Airport</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('transfer_type')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Airport and City Selection -->
                            <div x-show="transferType !== ''" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0">

                                <!-- For Pickup: Airport and Destination City -->
                                <div x-show="transferType === 'pickup'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="pickup_airport_id"
                                            class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            Pickup Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="pickup_airport_id" name="pickup_airport_id"
                                            x-model="selectedPickupAirport"
                                            :required="serviceType === 'airport_transfer' && transferType === 'pickup'"
                                            :disabled="false"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('pickup_airport_id') border-red-300 bg-red-50 @enderror">
                                            <option value="">Select pickup airport...</option>
                                            @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}"
                                                {{ old('pickup_airport_id') == $airport->id ? 'selected' : '' }}>
                                                {{ $airport->full_name }} - {{ $airport->city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('pickup_airport_id')
                                        <div class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="airport_dropoff_city_id"
                                            class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Destination City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="airport_dropoff_city_id" name="dropoff_city_id"
                                            x-model="selectedDropoffCity"
                                            :required="serviceType === 'airport_transfer' && transferType === 'pickup'"
                                            :disabled="false"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('dropoff_city_id') border-red-300 bg-red-50 @enderror">
                                            <option value="">Select destination city...</option>
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('dropoff_city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('dropoff_city_id')
                                        <div class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- For Dropoff: Origin City and Airport -->
                                <div x-show="transferType === 'dropoff'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="airport_pickup_city_id"
                                            class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Origin City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="airport_pickup_city_id" name="pickup_city_id"
                                            x-model="selectedPickupCity"
                                            :required="serviceType === 'airport_transfer' && transferType === 'dropoff'"
                                            :disabled="false"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('pickup_city_id') border-red-300 bg-red-50 @enderror">
                                            <option value="">Select origin city...</option>
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('pickup_city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('pickup_city_id')
                                        <div class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="dropoff_airport_id"
                                            class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                            Drop-off Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="dropoff_airport_id" name="dropoff_airport_id"
                                            x-model="selectedDropoffAirport"
                                            :required="serviceType === 'airport_transfer' && transferType === 'dropoff'"
                                            :disabled="false"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('dropoff_airport_id') border-red-300 bg-red-50 @enderror">
                                            <option value="">Select drop-off airport...</option>
                                            @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}"
                                                {{ old('dropoff_airport_id') == $airport->id ? 'selected' : '' }}>
                                                {{ $airport->full_name }} - {{ $airport->city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('dropoff_airport_id')
                                        <div class="flex items-center mt-2 text-sm text-red-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Airport Surcharges -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                                <div class="space-y-2">
                                    <label for="airport_pickup_surcharge"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Airport Pickup Surcharge (KSh)
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="airport_pickup_surcharge"
                                            name="airport_pickup_surcharge"
                                            value="{{ old('airport_pickup_surcharge', '0') }}" step="0.01" min="0"
                                            class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('airport_pickup_surcharge') border-red-300 bg-red-50 @enderror">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">KSh</span>
                                        </div>
                                    </div>
                                    @error('airport_pickup_surcharge')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="airport_dropoff_surcharge"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Airport Dropoff Surcharge (KSh)
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="airport_dropoff_surcharge"
                                            name="airport_dropoff_surcharge"
                                            value="{{ old('airport_dropoff_surcharge', '0') }}" step="0.01" min="0"
                                            class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('airport_dropoff_surcharge') border-red-300 bg-red-50 @enderror">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">KSh</span>
                                        </div>
                                    </div>
                                    @error('airport_dropoff_surcharge')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regular Route Selection -->
                <div x-show="needsRoute && serviceType !== 'airport_transfer'" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Route Configuration</h3>
                                    <p class="text-sm text-gray-600">Configure pickup and dropoff locations</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label for="regular_pickup_city_id"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pickup City
                                    </label>
                                    <select id="regular_pickup_city_id" name="pickup_city_id"
                                        :disabled="serviceType === 'airport_transfer'"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 disabled:bg-gray-100 disabled:text-gray-400 @error('pickup_city_id') border-red-300 bg-red-50 @enderror">
                                        <option value="">Select pickup city...</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('pickup_city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('pickup_city_id')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="regular_dropoff_city_id"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                        Dropoff City
                                    </label>
                                    <select id="regular_dropoff_city_id" name="dropoff_city_id"
                                        :disabled="serviceType === 'airport_transfer'"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 disabled:bg-gray-100 disabled:text-gray-400 @error('dropoff_city_id') border-red-300 bg-red-50 @enderror">
                                        <option value="">Select dropoff city...</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('dropoff_city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('dropoff_city_id')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="distance_km"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        Distance (km)
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="distance_km" name="distance_km"
                                            value="{{ old('distance_km') }}" min="0"
                                            class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('distance_km') border-red-300 bg-red-50 @enderror"
                                            placeholder="Optional">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">km</span>
                                        </div>
                                    </div>
                                    @error('distance_km')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Type & Additional Configuration -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Vehicle Type -->
                    <div x-show="needsVehicleType" x-cloak>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Vehicle Type</h3>
                                        <p class="text-sm text-gray-600">Select the vehicle category</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="space-y-2">
                                    <label for="vehicle_type_id"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                        </svg>
                                        Vehicle Type
                                        <span x-show="serviceType === 'airport_transfer'"
                                            class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select id="vehicle_type_id" name="vehicle_type_id"
                                        :required="serviceType === 'airport_transfer'"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('vehicle_type_id') border-red-300 bg-red-50 @enderror">
                                        <option value="">Select vehicle type...</option>
                                        @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{ $vehicleType->id }}"
                                            {{ old('vehicle_type_id') == $vehicleType->id ? 'selected' : '' }}>
                                            {{ $vehicleType->name }} ({{ $vehicleType->capacity }} seater)
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parcel Delivery Configuration -->
                    <div x-show="serviceType === 'parcel_delivery'" x-cloak>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                            <div
                                class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Parcel Delivery</h3>
                                        <p class="text-sm text-gray-600">Configure parcel-specific settings</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="space-y-2">
                                    <label for="parcel_type"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Parcel Type
                                    </label>
                                    <select id="parcel_type" name="parcel_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('parcel_type') border-red-300 bg-red-50 @enderror">
                                        <option value="">Select parcel type...</option>
                                        <option value="documents"
                                            {{ old('parcel_type') === 'documents' ? 'selected' : '' }}>Documents
                                        </option>
                                        <option value="small" {{ old('parcel_type') === 'small' ? 'selected' : '' }}>
                                            Small Package</option>
                                        <option value="medium" {{ old('parcel_type') === 'medium' ? 'selected' : '' }}>
                                            Medium Package</option>
                                        <option value="large" {{ old('parcel_type') === 'large' ? 'selected' : '' }}>
                                            Large Package</option>
                                    </select>
                                    @error('parcel_type')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="weight_limit"
                                        class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l3-1m-3 1l-3-1" />
                                        </svg>
                                        Weight Limit (kg)
                                    </label>
                                    <div class="relative">
                                        <input type="number" id="weight_limit" name="weight_limit"
                                            value="{{ old('weight_limit') }}" step="0.1" min="0"
                                            class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('weight_limit') border-red-300 bg-red-50 @enderror"
                                            placeholder="Optional">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">kg</span>
                                        </div>
                                    </div>
                                    @error('weight_limit')
                                    <div class="flex items-center mt-2 text-sm text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Pricing -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Additional Pricing</h3>
                                <p class="text-sm text-gray-600">Configure per-kilometer and per-day pricing</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="price_per_km" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    Price per Kilometer (KSh)
                                </label>
                                <div class="relative">
                                    <input type="number" id="price_per_km" name="price_per_km"
                                        value="{{ old('price_per_km') }}" step="0.01" min="0"
                                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('price_per_km') border-red-300 bg-red-50 @enderror"
                                        placeholder="Optional">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">KSh</span>
                                    </div>
                                </div>
                                @error('price_per_km')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div x-show="serviceType === 'car_hire'" x-cloak class="space-y-2">
                                <label for="price_per_day" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h6a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                    </svg>
                                    Price per Day (KSh)
                                </label>
                                <div class="relative">
                                    <input type="number" id="price_per_day" name="price_per_day"
                                        value="{{ old('price_per_day') }}" step="0.01" min="0"
                                        class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('price_per_day') border-red-300 bg-red-50 @enderror"
                                        placeholder="For car hire service">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">KSh</span>
                                    </div>
                                </div>
                                @error('price_per_day')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Surcharges & Additional Fees -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Surcharges & Additional Fees</h3>
                                <p class="text-sm text-gray-600">Configure weekend and night time surcharges</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <label for="weekend_surcharge_percentage"
                                    class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h6a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                    </svg>
                                    Weekend Surcharge (%)
                                </label>
                                <div class="relative">
                                    <input type="number" id="weekend_surcharge_percentage"
                                        name="weekend_surcharge_percentage"
                                        value="{{ old('weekend_surcharge_percentage', '0') }}" step="0.01" min="0"
                                        max="100"
                                        class="w-full pl-4 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('weekend_surcharge_percentage') border-red-300 bg-red-50 @enderror">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">%</span>
                                    </div>
                                </div>
                                @error('weekend_surcharge_percentage')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="night_surcharge_percentage"
                                    class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                    Night Surcharge (%)
                                </label>
                                <div class="relative">
                                    <input type="number" id="night_surcharge_percentage"
                                        name="night_surcharge_percentage"
                                        value="{{ old('night_surcharge_percentage', '0') }}" step="0.01" min="0"
                                        max="100"
                                        class="w-full pl-4 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('night_surcharge_percentage') border-red-300 bg-red-50 @enderror">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">%</span>
                                    </div>
                                </div>
                                @error('night_surcharge_percentage')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="night_start_time"
                                    class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Night Start Time
                                </label>
                                <input type="time" id="night_start_time" name="night_start_time"
                                    value="{{ old('night_start_time', '22:00') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('night_start_time') border-red-300 bg-red-50 @enderror">
                                @error('night_start_time')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="night_end_time" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Night End Time
                                </label>
                                <input type="time" id="night_end_time" name="night_end_time"
                                    value="{{ old('night_end_time', '06:00') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('night_end_time') border-red-300 bg-red-50 @enderror">
                                @error('night_end_time')
                                <div class="flex items-center mt-2 text-sm text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Active Pricing Rule</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1 ml-7">Only active pricing rules will be used for
                                    calculations</p>
                            </div>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.transportation.pricing.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Create Pricing Rule
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function pricingForm() {
        return {
            selectedService: '{{ old('
            transportation_service_id ', request('
            service_id ')) }}',
            serviceType: '',
            transferType: '{{ old('
            transfer_type ') }}',
            selectedPickupAirport: '{{ old('
            pickup_airport_id ') }}',
            selectedDropoffAirport: '{{ old('
            dropoff_airport_id ') }}',
            selectedPickupCity: '{{ old('
            pickup_city_id ') }}',
            selectedDropoffCity: '{{ old('
            dropoff_city_id ') }}',
            needsRoute: false,
            needsVehicleType: false,

            init() {
                console.log('PricingForm initialized');
                if (this.selectedService) {
                    this.updateServiceType();
                }
            },

            updateServiceType() {
                const select = document.getElementById('transportation_service_id');
                if (!select) return;

                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.dataset.type) {
                    this.serviceType = selectedOption.dataset.type;
                    this.needsRoute = ['shared_ride', 'solo_ride', 'parcel_delivery'].includes(this.serviceType);
                    this.needsVehicleType = ['solo_ride', 'airport_transfer', 'car_hire'].includes(this.serviceType);
                } else {
                    this.serviceType = '';
                    this.needsRoute = false;
                    this.needsVehicleType = false;
                }
            },

            resetAirportFields() {
                this.selectedPickupAirport = '';
                this.selectedDropoffAirport = '';
                this.selectedPickupCity = '';
                this.selectedDropoffCity = '';
            },

            handleFormSubmit(event) {
                console.log('Form submitted with transfer type:', this.transferType);

                // Clear unused fields based on transfer type
                if (this.serviceType === 'airport_transfer') {
                    if (this.transferType === 'pickup') {
                        // Clear dropoff fields
                        const pickupCity = document.getElementById('airport_pickup_city_id');
                        const dropoffAirport = document.getElementById('dropoff_airport_id');
                        if (pickupCity) pickupCity.value = '';
                        if (dropoffAirport) dropoffAirport.value = '';
                    } else if (this.transferType === 'dropoff') {
                        // Clear pickup fields
                        const pickupAirport = document.getElementById('pickup_airport_id');
                        const dropoffCity = document.getElementById('airport_dropoff_city_id');
                        if (pickupAirport) pickupAirport.value = '';
                        if (dropoffCity) dropoffCity.value = '';
                    }

                    // Clear regular route fields
                    const regularPickupCity = document.getElementById('regular_pickup_city_id');
                    const regularDropoffCity = document.getElementById('regular_dropoff_city_id');
                    if (regularPickupCity) regularPickupCity.value = '';
                    if (regularDropoffCity) regularDropoffCity.value = '';
                }

                return true;
            }
        }
    }
    </script>

    <style>
    [x-cloak] {
        display: none !important;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Custom focus styles */
    .focus\:ring-2:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    /* Improved hover effects */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }

    /* Enhanced form styling */
    input[type="radio"]:checked+div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    select:focus,
    input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Disabled state styling */
    select:disabled,
    input:disabled {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
        border-color: #d1d5db;
    }

    select:disabled:focus,
    input:disabled:focus {
        box-shadow: none;
        border-color: #d1d5db;
    }
    </style>
</x-admin.layouts.app>