<!-- Airport Transfer Booking Modal -->
<div id="airport-transfer-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-3 py-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div
                class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-slate-900/80 to-gray-900/80 backdrop-blur-sm">
            </div>
        </div>

        <!-- Modal panel - Compact version -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-6 sm:align-middle sm:max-w-4xl sm:w-full max-h-[90vh] overflow-y-auto border-2 border-white/20 backdrop-blur-sm"
            style="box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1)">

            <!-- Modal Header - Compact -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-700 px-5 py-4 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Airport Transfer</h3>
                    </div>
                    <button id="close-airport-modal"
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Compact -->
            <form id="airport-transfer-form" class="px-5 py-4">
                @csrf

                <!-- Transfer Type Selection - Compact -->
                <div class="mb-5">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-2 border border-blue-200">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        Transfer Type
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="radio" id="pickup_transfer" name="transfer_type" value="pickup" class="sr-only"
                                required>
                            <label for="pickup_transfer"
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-base font-semibold text-gray-800">Airport Pickup</h5>
                                        <p class="text-xs text-gray-600">From airport to your destination</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="radio" id="dropoff_transfer" name="transfer_type" value="dropoff"
                                class="sr-only" required>
                            <label for="dropoff_transfer"
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                            </path>
                                            <path
                                                d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="text-base font-semibold text-gray-800">Airport Drop-off</h5>
                                        <p class="text-xs text-gray-600">From your location to airport</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Content Grid - Compact -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <!-- Left Column: Trip Details - Compact -->
                    <div
                        class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200 shadow-md">
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

                        <!-- Route Selection - Compact -->
                        <div class="space-y-3">
                            <!-- Airport Pickup Route -->
                            <div id="pickup-route" class="hidden route-section">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div>
                                        <label for="pickup_airport"
                                            class="block text-xs font-semibold text-gray-700 mb-1">
                                            Pickup Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="pickup_airport" name="pickup_airport_id"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                            <option value="">Select airport</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="destination_city"
                                            class="block text-xs font-semibold text-gray-700 mb-1">
                                            Destination City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="destination_city" name="dropoff_city_id"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Airport Drop-off Route -->
                            <div id="dropoff-route" class="hidden route-section">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div>
                                        <label for="origin_city" class="block text-xs font-semibold text-gray-700 mb-1">
                                            Origin City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="origin_city" name="pickup_city_id"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                            <option value="">Select city</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="dropoff_airport"
                                            class="block text-xs font-semibold text-gray-700 mb-1">
                                            Drop-off Airport <span class="text-red-500">*</span>
                                        </label>
                                        <select id="dropoff_airport" name="dropoff_airport_id"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                            <option value="">Select airport</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Type Selection -->
                            <div>
                                <label for="airport_vehicle_type"
                                    class="block text-xs font-semibold text-gray-700 mb-1">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select id="airport_vehicle_type" name="vehicle_type_id"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                    required>
                                    <option value="">Select vehicle type</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-0.5">Choose your preferred vehicle</p>
                            </div>

                            <!-- Travel Details - Compact -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div>
                                    <label for="airport_travel_date"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="airport_travel_date" name="travel_date"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="airport_travel_time"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="airport_travel_time" name="travel_time"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                        required>
                                </div>

                                <div>
                                    <label for="airport_passengers"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Passengers <span class="text-red-500">*</span>
                                    </label>
                                    <select id="airport_passengers" name="passengers"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                        required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Flight Details -->
                            <div>
                                <label for="flight_number" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Flight Number (Optional)
                                </label>
                                <input type="text" id="flight_number" name="flight_number"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                    placeholder="e.g., KQ101">
                                <p class="text-xs text-gray-500 mt-0.5">Helps track your flight</p>
                            </div>
                        </div>

                        <!-- Price Display - Compact -->
                        <div id="airport-price-display"
                            class="hidden mt-3 p-3 bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <div class="p-1.5 bg-blue-100 rounded mr-2 border border-blue-200">
                                    <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                </div>
                                <h5 class="text-xs font-bold text-blue-800">Transfer Pricing</h5>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700">Total Price:</span>
                                <span id="airport-price-amount" class="text-xl font-bold text-blue-600"></span>
                            </div>
                            <div id="airport-price-breakdown" class="text-xs text-gray-600 mt-1">
                                <!-- Price breakdown will be shown here -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Contact & Account Information - Compact -->
                    <div class="space-y-4">
                        <!-- Contact Information -->
                        <div
                            class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-4 border border-cyan-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <div class="p-2 bg-cyan-100 rounded-lg mr-2 border border-cyan-200">
                                    <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                                Contact Information
                            </h4>

                            <div class="space-y-3">
                                <div>
                                    <label for="airport_customer_name"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="airport_customer_name" name="customer_name"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-cyan-600 focus:border-cyan-600"
                                        required>
                                </div>

                                <div>
                                    <label for="airport_customer_email"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="airport_customer_email" name="customer_email"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-cyan-600 focus:border-cyan-600"
                                        required>
                                    <p class="text-xs text-gray-500 mt-0.5">For account and booking updates</p>
                                </div>

                                <div>
                                    <label for="airport_customer_phone"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="airport_customer_phone" name="customer_phone"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-cyan-600 focus:border-cyan-600"
                                        placeholder="+254 7XX XXX XXX" required>
                                </div>
                            </div>
                        </div>

                        <!-- Account Password Section - Compact -->
                        <div
                            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-2 border border-blue-200">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Account Password
                            </h4>

                            <div class="space-y-3">
                                <div>
                                    <label for="airport_password"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="airport_password" name="password"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-0.5">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="airport_password_confirmation"
                                        class="block text-xs font-semibold text-gray-700 mb-1">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="airport_password_confirmation"
                                        name="password_confirmation"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-0.5">Re-enter your password</p>
                                </div>
                            </div>

                            <!-- Additional Info - Compact -->
                            <div
                                class="mt-4 p-3 bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="p-1.5 bg-blue-100 rounded mr-2 border border-blue-200">
                                        <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h5 class="text-xs font-bold text-blue-800">Airport Transfer Benefits</h5>
                                </div>
                                <ul class="text-xs text-gray-600 space-y-0.5">
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Professional drivers
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Flight tracking service
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Meet & greet service
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions - Compact -->
                <div class="mt-6 flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-airport-booking"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-cyan-700 text-white rounded-lg hover:from-cyan-700 hover:to-blue-600 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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