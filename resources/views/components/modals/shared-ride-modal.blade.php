<!-- Shared Ride Booking Modal -->
<div id="shared-ride-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-brown-custom to-amber-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Book Your Shared Ride</h3>
                    <button id="close-modal" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="shared-ride-form" class="px-6 py-6">
                @csrf
                
                <!-- Form Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Left Column: Trip Details -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                                Trip Details
                            </h4>
                            
                            <!-- Route Selection -->
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="pickup_city" class="block text-sm font-medium text-gray-700 mb-2">
                                            Pickup City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="pickup_city" name="pickup_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                            <option value="">Select pickup city</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="dropoff_city" class="block text-sm font-medium text-gray-700 mb-2">
                                            Drop-off City <span class="text-red-500">*</span>
                                        </label>
                                        <select id="dropoff_city" name="dropoff_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                            <option value="">Select drop-off city</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Travel Details -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label for="travel_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Travel Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="travel_date" name="travel_date" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div>
                                        <label for="travel_time" class="block text-sm font-medium text-gray-700 mb-2">
                                            Preferred Time <span class="text-red-500">*</span>
                                        </label>
                                        <input type="time" id="travel_time" name="travel_time" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required>
                                    </div>

                                    <div>
                                        <label for="passengers" class="block text-sm font-medium text-gray-700 mb-2">
                                            Passengers <span class="text-red-500">*</span>
                                        </label>
                                        <select id="passengers" name="passengers" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                            <option value="1">1 Passenger</option>
                                            <option value="2">2 Passengers</option>
                                            <option value="3">3 Passengers</option>
                                            <option value="4">4 Passengers</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price Display -->
                        <div id="price-display" class="hidden p-4 bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Estimated Price:</span>
                                <span id="price-amount" class="text-2xl font-bold text-orange-custom"></span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Price per passenger for shared ride</p>
                        </div>
                    </div>
                    
                    <!-- Right Column: Contact & Account Information -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Contact Information
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="customer_name" name="customer_name" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                        required>
                                </div>

                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="customer_email" name="customer_email" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">We'll use this for your account login and booking updates</p>
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="customer_phone" name="customer_phone" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                        placeholder="+254 7XX XXX XXX" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Password Section -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Account Password
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="cancel-booking" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-orange-custom to-red-500 text-white rounded-lg hover:from-red-500 hover:to-orange-custom transition-all transform hover:scale-105 shadow-lg font-medium">
                        Complete Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
