<!-- Shared Ride Booking Modal -->
<div id="shared-ride-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-3 py-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div
                class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-slate-900/80 to-gray-900/80 backdrop-blur-sm">
            </div>
        </div>

        <!-- Modal panel - Reduced max width and padding -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-6 sm:align-middle sm:max-w-4xl sm:w-full max-h-[90vh] overflow-y-auto border-2 border-white/20 backdrop-blur-sm"
            style="box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1)">

            <!-- Modal Header - Reduced padding -->
            <div
                class="bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 px-5 py-4 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Shared Ride</h3>
                    </div>
                    <button id="close-modal"
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Reduced padding -->
            <form id="shared-ride-form" class="px-5 py-4">
                @csrf

                <!-- Form Content in 3 Columns - Reduced gaps -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                    <!-- Column 1: Trip Details - Compact spacing -->
                    <div
                        class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-orange-100 rounded-lg mr-2 border border-orange-200">
                                <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                    </path>
                                </svg>
                            </div>
                            Trip Details
                        </h4>

                        <div class="space-y-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <label for="pickup_city" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Pickup City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="pickup_city" name="pickup_city_id"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select city</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="dropoff_city" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Drop-off City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="dropoff_city" name="dropoff_city_id"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select city</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div>
                                    <label for="travel_date" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Travel Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="travel_date" name="travel_date"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="travel_time" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="travel_time" name="travel_time"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        required>
                                </div>

                                <div>
                                    <label for="passengers" class="block text-xs font-semibold text-gray-700 mb-1">
                                        Passengers <span class="text-red-500">*</span>
                                    </label>
                                    <select id="passengers" name="passengers"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Price Display - Compact -->
                            <div id="price-display" class="hidden">
                                <div
                                    class="bg-gradient-to-br from-orange-50 via-amber-50 to-orange-50 border border-orange-200 rounded-lg p-3">
                                    <div class="flex items-center mb-2">
                                        <div class="p-1.5 bg-orange-100 rounded mr-2 border border-orange-200">
                                            <svg class="w-3 h-3 text-orange-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-xs font-bold text-orange-800">Shared Ride Pricing</h5>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700">Estimated:</span>
                                        <span id="price-amount" class="text-xl font-bold text-orange-600"></span>
                                    </div>
                                    <p id="price-description" class="text-xs text-gray-600 mt-1">Total for 1 passenger</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact Information - Compact spacing -->
                    <div
                        class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl p-4 border border-amber-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-amber-100 rounded-lg mr-2 border border-amber-200">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Contact Information
                        </h4>

                        <div class="space-y-3">
                            <div>
                                <label for="customer_name" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="customer_name" name="customer_name"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="customer_email" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="customer_email" name="customer_email"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                    required>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    For account and booking updates
                                </p>
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="customer_phone" name="customer_phone"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Password - Compact spacing -->
                    <div
                        class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl p-4 border border-red-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg mr-2 border border-red-200">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Account Password
                        </h4>

                        <div class="space-y-3">
                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                    required minlength="4">
                                <p class="text-xs text-gray-500 mt-0.5">Minimum 4 characters</p>
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-xs font-semibold text-gray-700 mb-1">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                    required minlength="4">
                                <p class="text-xs text-gray-500 mt-0.5">Re-enter your password</p>
                            </div>

                            <!-- Additional Info Section - Compact -->
                            <div
                                class="mt-4 p-3 bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="p-1.5 bg-orange-100 rounded mr-2 border border-orange-200">
                                        <svg class="w-3 h-3 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h5 class="text-xs font-bold text-orange-800">Shared Ride Benefits</h5>
                                </div>
                                <ul class="text-xs text-gray-600 space-y-0.5">
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Cost-effective travel
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Meet fellow travelers
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-2.5 h-2.5 mr-1.5 text-green-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Eco-friendly transport
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions - Compact -->
                <div class="mt-6 flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-booking"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-orange-600 via-amber-600 to-red-500 text-white rounded-lg hover:from-red-500 hover:via-amber-600 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
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