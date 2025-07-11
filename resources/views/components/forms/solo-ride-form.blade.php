<!-- Solo Ride Inline Booking Form -->
<div id="solo-ride-form-container" class="hidden mt-8 animate-fade-in">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Solo Ride</h3>
                    </div>
                    <button id="close-solo-ride-form" 
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Body -->
            <form id="solo-ride-form" class="px-6 py-5">
                @csrf

                <!-- Form Content in 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <!-- Column 1: Trip Details -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-5 border border-gray-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-2 border border-green-200">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                    </path>
                                </svg>
                            </div>
                            Trip Details
                        </h4>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="solo_pickup_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_pickup_city" name="pickup_city_id"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select pickup city</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="solo_dropoff_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Drop-off City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_dropoff_city" name="dropoff_city_id"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select drop-off city</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="solo_vehicle_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select id="solo_vehicle_type" name="vehicle_type_id"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Select vehicle type</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Choose your preferred vehicle for solo journey
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label for="solo_travel_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Travel Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="solo_travel_date" name="travel_date"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="solo_travel_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Preferred Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="solo_travel_time" name="travel_time"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                        required>
                                </div>

                                <div>
                                    <label for="solo_passengers" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Passengers <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_passengers" name="passengers"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="1">1 Passenger</option>
                                        <option value="2">2 Passengers</option>
                                        <option value="3">3 Passengers</option>
                                        <option value="4">4 Passengers</option>
                                        <option value="5">5 Passengers</option>
                                        <option value="6">6+ Passengers</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price Display -->
                            <div id="solo-price-display" class="hidden">
                                <div class="bg-gradient-to-br from-green-50 via-emerald-50 to-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-green-100 rounded mr-2 border border-green-200">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-green-800">Solo Ride Pricing</h5>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700">Total Price:</span>
                                        <span id="solo-price-amount" class="text-2xl font-bold text-green-600"></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">Private vehicle for your exclusive use</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact Information -->
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-5 border border-emerald-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-emerald-100 rounded-lg mr-2 border border-emerald-200">
                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Contact Information
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label for="solo_customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="solo_customer_name" name="customer_name"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="solo_customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="solo_customer_email" name="customer_email"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                    required>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    For account login and booking updates
                                </p>
                            </div>

                            <div>
                                <label for="solo_customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="solo_customer_phone" name="customer_phone"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Password & Special Requirements -->
                    <div class="space-y-5">
                        <!-- Password Section -->
                        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-5 border border-teal-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-teal-100 rounded-lg mr-2 border border-teal-200">
                                    <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Account Password
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="solo_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="solo_password" name="password"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="solo_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="solo_password_confirmation" name="password_confirmation"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-2 border border-purple-200">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Special Requirements
                            </h4>

                            <div>
                                <label for="solo_special_requirements" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Additional Notes (Optional)
                                </label>
                                <textarea id="solo_special_requirements" name="special_requirements" rows="4"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 resize-none"
                                    placeholder="Any special requirements, luggage details, or additional information..."></textarea>
                            </div>

                            <!-- Solo Ride Benefits Section -->
                            <div class="mt-4 p-4 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="p-2 bg-green-100 rounded mr-2 border border-green-200">
                                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h5 class="text-sm font-bold text-green-800">Solo Ride Benefits</h5>
                                </div>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Private vehicle for exclusive use
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Flexible departure times
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Door-to-door service
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Professional driver included
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-solo-ride-booking"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:via-emerald-700 hover:to-green-800 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
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
