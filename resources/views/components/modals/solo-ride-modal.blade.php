<!-- Solo Ride Booking Modal -->
<div id="solo-ride-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-2 py-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div
                class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-slate-900/80 to-gray-900/80 backdrop-blur-sm">
            </div>
        </div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full max-h-[95vh] overflow-y-auto">

            <!-- Modal Header -->
            <div
                class="bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 px-8 py-6 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Book Your Solo Ride</h3>
                    </div>
                    <button id="close-solo-modal"
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-lg transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="solo-ride-form" class="px-8 py-6">
                @csrf

                <!-- Form Content in 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Column 1: Trip Details -->
                    <div
                        class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                    </path>
                                </svg>
                            </div>
                            Trip Details
                        </h4>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="solo_pickup_city"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_pickup_city" name="pickup_city_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white shadow-sm"
                                        required>
                                        <option value="">Select pickup city</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="solo_dropoff_city"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Drop-off City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_dropoff_city" name="dropoff_city_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white shadow-sm"
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white shadow-sm"
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
                                    <label for="solo_travel_date"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Travel Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="solo_travel_date" name="travel_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="solo_travel_time"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Preferred Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="solo_travel_time" name="travel_time"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm"
                                        required>
                                </div>

                                <div>
                                    <label for="solo_passengers" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Passengers <span class="text-red-500">*</span>
                                    </label>
                                    <select id="solo_passengers" name="passengers"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white shadow-sm"
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
                                <div
                                    class="bg-gradient-to-br from-green-50 via-emerald-50 to-green-50 border-2 border-green-200 rounded-xl p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="p-1 bg-green-100 rounded-lg mr-2">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-green-800">Ride Pricing</h5>
                                    </div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-gray-700 font-medium">Total Price:</span>
                                        <span id="solo-price-amount" class="text-2xl font-bold text-green-600"></span>
                                    </div>
                                    <p class="text-xs text-gray-600 bg-green-50 px-3 py-1 rounded-full text-center">
                                        Private vehicle for your exclusive use</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact Information -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                        <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Contact Information
                        </h4>

                        <div class="space-y-5">
                            <div>
                                <label for="solo_customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="solo_customer_name" name="customer_name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm"
                                    required>
                            </div>

                            <div>
                                <label for="solo_customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="solo_customer_email" name="customer_email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm"
                                    required>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Password & Special Requirements -->
                    <div class="space-y-6">
                        <!-- Password Section -->
                        <div
                            class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200 shadow-sm">
                            <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="solo_password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="solo_password_confirmation" name="password_confirmation"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements -->
                        <div
                            class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-6 border border-orange-200 shadow-sm">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Special Requirements
                            </h4>

                            <div>
                                <label for="solo_special_requirements"
                                    class="block text-sm font-semibold text-gray-700 mb-2">
                                    Additional Notes (Optional)
                                </label>
                                <textarea id="solo_special_requirements" name="special_requirements" rows="6"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm resize-none"
                                    placeholder="Any special requirements, luggage details, or additional information..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="cancel-solo-booking"
                        class="px-8 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold shadow-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-10 py-3 bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:via-emerald-700 hover:to-green-800 transition-all duration-200 transform hover:scale-105 shadow-lg font-semibold">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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