<!-- Airport Transfer Inline Booking Form -->
<div id="airport-transfer-form-container" class="hidden mt-8 animate-fade-in">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Airport Transfer</h3>
                    </div>
                    <button id="close-airport-transfer-form" 
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Body -->
            <form id="airport-transfer-form" class="px-6 py-5">
                @csrf

                <!-- Transfer Type Selection -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-2 border border-blue-200">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        Transfer Type
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <input type="radio" id="pickup_transfer" name="transfer_type" value="pickup" class="sr-only" required>
                            <label for="pickup_transfer"
                                class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-800">Airport Pickup</h5>
                                        <p class="text-sm text-gray-600">From airport to your destination</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" id="dropoff_transfer" name="transfer_type" value="dropoff" class="sr-only" required>
                            <label for="dropoff_transfer"
                                class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                            </path>
                                            <path
                                                d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-800">Airport Drop-off</h5>
                                        <p class="text-sm text-gray-600">From your location to airport</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Content in 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <!-- Column 1: Trip Details -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-5 border border-gray-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-2 border border-blue-200">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Trip Details
                        </h4>

                        <div class="space-y-4">
                            <!-- Airport Pickup Route -->
                            <div id="pickup-route" class="hidden route-section">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="pickup_airport" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Pickup Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="pickup_airport" name="pickup_airport_id"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white">
                                            <option value="">Select airport</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="destination_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Destination City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="destination_city" name="dropoff_city_id"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Airport Drop-off Route -->
                            <div id="dropoff-route" class="hidden route-section">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="origin_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Origin City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="origin_city" name="pickup_city_id"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="dropoff_airport" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Drop-off Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="dropoff_airport" name="dropoff_airport_id"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white">
                                            <option value="">Select airport</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Type -->
                            <div>
                                <label for="airport_vehicle_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select id="airport_vehicle_type" name="vehicle_type_id"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Select vehicle type</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Choose based on your comfort and group size</p>
                            </div>

                            <!-- Number of Passengers -->
                            <div>
                                <label for="airport_passengers" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Number of Passengers <span class="text-red-500">*</span>
                                </label>
                                <select id="airport_passengers" name="passengers"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Select passengers</option>
                                    <option value="1">1 passenger</option>
                                    <option value="2">2 passengers</option>
                                    <option value="3">3 passengers</option>
                                    <option value="4">4 passengers</option>
                                    <option value="5">5 passengers</option>
                                    <option value="6">6 passengers</option>
                                    <option value="7">7 passengers</option>
                                    <option value="8">8 passengers</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Total number of people including yourself</p>
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="airport_pickup_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="airport_pickup_date" name="travel_date"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="airport_pickup_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="airport_pickup_time" name="travel_time"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-200"
                                        required>
                                </div>
                            </div>

                            <!-- Price Display -->
                            <div id="airport-price-display" class="hidden">
                                <div class="bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-blue-100 rounded mr-2 border border-blue-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-blue-800">Transfer Pricing</h5>
                                    </div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-700">Total Price:</span>
                                        <span id="airport-price-amount" class="text-2xl font-bold text-blue-600"></span>
                                    </div>
                                    <div id="airport-price-breakdown" class="text-xs text-gray-600 bg-blue-50 px-3 py-2 rounded-lg">
                                        Price breakdown will appear here
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact Information -->
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-5 border border-cyan-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-cyan-100 rounded-lg mr-2 border border-cyan-200">
                                <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Contact Information
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label for="airport_customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="airport_customer_name" name="customer_name"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="airport_customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="airport_customer_email" name="customer_email"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    required>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    For booking confirmations and updates
                                </p>
                            </div>

                            <div>
                                <label for="airport_customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="airport_customer_phone" name="customer_phone"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Password & Flight Details -->
                    <div class="space-y-5">
                        <!-- Password Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-2 border border-purple-200">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Account Password
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="airport_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="airport_password" name="password"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="airport_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="airport_password_confirmation" name="password_confirmation"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                                </div>
                            </div>
                        </div>

                        <!-- Flight Details Section -->
                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-5 border border-orange-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-2 border border-orange-200">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z">
                                        </path>
                                    </svg>
                                </div>
                                Flight Details
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="flight_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Flight Number (Optional)
                                    </label>
                                    <input type="text" id="flight_number" name="flight_number"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        placeholder="e.g., KQ101">
                                    <p class="text-xs text-gray-500 mt-1">For flight tracking and delays</p>
                                </div>

                                <div>
                                    <label for="special_instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Special Instructions (Optional)
                                    </label>
                                    <textarea id="special_instructions" name="special_instructions" rows="4"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none"
                                        placeholder="Any special requirements, meeting points, or additional information..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-airport-transfer-booking"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:via-cyan-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Complete Booking
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
