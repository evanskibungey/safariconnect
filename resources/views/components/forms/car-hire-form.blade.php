<!-- Car Hire Inline Booking Form -->
<div id="car-hire-form-container" class="hidden mt-8 animate-fade-in">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                </path>
                                <path
                                    d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Car Hire</h3>
                    </div>
                    <button id="close-car-hire-form" 
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Body -->
            <form id="car-hire-form" class="px-6 py-5">
                @csrf

                <!-- Form Content in 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <!-- Column 1: Vehicle & Rental Details -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-5 border border-gray-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-teal-100 rounded-lg mr-2 border border-teal-200">
                                <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                    </path>
                                    <path
                                        d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                    </path>
                                </svg>
                            </div>
                            Vehicle Details
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label for="car_hire_vehicle_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select id="car_hire_vehicle_type" name="vehicle_type_id"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Select vehicle type</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Choose your preferred vehicle category
                                </p>
                            </div>

                            <div>
                                <label for="pickup_location" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pickup Location <span class="text-red-500">*</span>
                                </label>
                                <select id="pickup_location" name="pickup_city_id"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Select pickup location</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="hire_start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="hire_start_date" name="hire_start_date"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="hire_end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        End Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="hire_end_date" name="hire_end_date"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="pickup_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pickup Time <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="pickup_time" name="pickup_time"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                    required>
                            </div>

                            <!-- Price Display -->
                            <div id="car-hire-price-display" class="hidden">
                                <div class="bg-gradient-to-br from-teal-50 via-cyan-50 to-teal-50 border border-teal-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-teal-100 rounded mr-2 border border-teal-200">
                                            <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-teal-800">Rental Pricing</h5>
                                    </div>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Per day:</span>
                                            <span id="car-hire-price-per-day" class="font-semibold text-teal-600"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Duration:</span>
                                            <span id="car-hire-duration" class="text-gray-700"></span>
                                        </div>
                                        <div class="border-t border-teal-200 pt-2 mt-2">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-700">Total:</span>
                                                <span id="car-hire-total-price" class="text-xl font-bold text-teal-600"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact & Driver Information -->
                    <div class="bg-gradient-to-br from-cyan-50 to-teal-50 rounded-xl p-5 border border-cyan-200 shadow-md">
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
                                <label for="car_hire_customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="car_hire_customer_name" name="customer_name"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="car_hire_customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="car_hire_customer_email" name="customer_email"
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
                                <label for="car_hire_customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="car_hire_customer_phone" name="customer_phone"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>

                            <div>
                                <label for="drivers_license_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Driver's License <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="drivers_license_number" name="drivers_license_number"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                    placeholder="License number" required>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Valid license required for car hire
                                </p>
                            </div>

                            <div>
                                <label for="car_hire_special_requirements" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Special Requirements (Optional)
                                </label>
                                <textarea id="car_hire_special_requirements" name="special_requirements" rows="3"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 resize-none"
                                    placeholder="Any special requests or requirements..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Setup & Benefits -->
                    <div class="space-y-5">
                        <!-- Password Section -->
                        <div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-xl p-5 border border-teal-200 shadow-md">
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
                                    <label for="car_hire_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="car_hire_password" name="password"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="car_hire_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="car_hire_password_confirmation" name="password_confirmation"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                                </div>
                            </div>
                        </div>

                        <!-- Car Hire Benefits -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-2 border border-blue-200">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Car Hire Benefits
                            </h4>

                            <ul class="text-xs text-gray-600 space-y-2">
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    24/7 roadside assistance
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Full insurance coverage included
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Flexible cancellation policy
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Unlimited mileage options
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    GPS navigation available
                                </li>
                            </ul>

                            <!-- Terms Notice -->
                            <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                <p class="text-xs text-amber-800 flex items-center">
                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    By booking, you agree to our rental terms and conditions.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-car-hire-booking"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-teal-600 via-cyan-600 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:via-cyan-700 hover:to-teal-800 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
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
