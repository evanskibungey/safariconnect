<!-- Car Hire Booking Modal -->
<div id="car-hire-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Book Your Car Hire</h3>
                    <button id="close-car-hire-modal" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="car-hire-form" class="px-6 py-6">
                @csrf
                
                <!-- Form Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Left Column: Vehicle & Hire Details -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                                </svg>
                                Vehicle & Rental Details
                            </h4>
                            
                            <!-- Vehicle Selection -->
                            <div class="space-y-4">
                                <div>
                                    <label for="car_hire_vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Vehicle Type <span class="text-red-500">*</span>
                                    </label>
                                    <select id="car_hire_vehicle_type" name="vehicle_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" required>
                                        <option value="">Select vehicle type</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pickup Location <span class="text-red-500">*</span>
                                    </label>
                                    <select id="pickup_location" name="pickup_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" required>
                                        <option value="">Select pickup location</option>
                                    </select>
                                </div>

                                <!-- Hire Period -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="hire_start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            Start Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="hire_start_date" name="hire_start_date" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                            required min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div>
                                        <label for="hire_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                            End Date <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date" id="hire_end_date" name="hire_end_date" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pickup Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="pickup_time" name="pickup_time" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Price Display -->
                        <div id="car-hire-price-display" class="hidden p-4 bg-gradient-to-r from-teal-50 to-cyan-50 border border-teal-200 rounded-lg">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Price per day:</span>
                                    <span id="car-hire-price-per-day" class="text-lg font-bold text-teal-600"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Hire duration:</span>
                                    <span id="car-hire-duration" class="text-sm text-gray-600"></span>
                                </div>
                                <div class="border-t border-teal-200 pt-2 mt-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-700 font-medium">Total Price:</span>
                                        <span id="car-hire-total-price" class="text-2xl font-bold text-teal-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Contact & Driver Information -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Contact Information
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="car_hire_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="car_hire_customer_name" name="customer_name" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        required>
                                </div>

                                <div>
                                    <label for="car_hire_customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="car_hire_customer_email" name="customer_email" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">We'll use this for your account login and booking updates</p>
                                </div>

                                <div>
                                    <label for="car_hire_customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="car_hire_customer_phone" name="customer_phone" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        placeholder="+254 7XX XXX XXX" required>
                                </div>

                                <div>
                                    <label for="drivers_license_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Driver's License Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="drivers_license_number" name="drivers_license_number" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        placeholder="Enter your valid driver's license number" required>
                                    <p class="text-xs text-gray-500 mt-1">A valid driver's license is required for car hire</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Password Section -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Account Password
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="car_hire_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="car_hire_password" name="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>
                                
                                <div>
                                    <label for="car_hire_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="car_hire_password_confirmation" name="password_confirmation" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements -->
                        <div>
                            <label for="car_hire_special_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                                Special Requirements (Optional)
                            </label>
                            <textarea id="car_hire_special_requirements" name="special_requirements" rows="3" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                placeholder="Any special requests or additional requirements..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="cancel-car-hire-booking" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all transform hover:scale-105 shadow-lg font-medium">
                        Complete Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
