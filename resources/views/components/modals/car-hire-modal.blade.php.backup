<!-- Car Hire Booking Modal -->
<div id="car-hire-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-3 py-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div
                class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-slate-900/80 to-gray-900/80 backdrop-blur-sm">
            </div>
        </div>

        <!-- Modal panel - Extended width for 3 columns -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-6 sm:align-middle sm:max-w-6xl sm:w-full max-h-[90vh] overflow-y-auto border-2 border-white/20 backdrop-blur-sm"
            style="box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1)">

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
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
                    <button id="close-car-hire-modal"
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="car-hire-form" class="px-6 py-5">
                @csrf

                <!-- Form Content Grid - 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                    <!-- Column 1: Vehicle & Rental Details -->
                    <div
                        class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-5 border border-teal-200 shadow-md">
                        <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
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
                                <label for="car_hire_vehicle_type"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Vehicle Type <span class="text-red-500">*</span>
                                </label>
                                <select id="car_hire_vehicle_type" name="vehicle_type_id"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                                    <option value="">Select vehicle type</option>
                                </select>
                            </div>

                            <div>
                                <label for="pickup_location" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Pickup Location <span class="text-red-500">*</span>
                                </label>
                                <select id="pickup_location" name="pickup_city_id"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                                    <option value="">Select location</option>
                                </select>
                            </div>

                            <div>
                                <label for="hire_start_date" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="hire_start_date" name="hire_start_date"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required min="{{ date('Y-m-d') }}">
                            </div>

                            <div>
                                <label for="hire_end_date" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="hire_end_date" name="hire_end_date"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                            </div>

                            <div>
                                <label for="pickup_time" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Pickup Time <span class="text-red-500">*</span>
                                </label>
                                <input type="time" id="pickup_time" name="pickup_time"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                            </div>
                        </div>

                        <!-- Price Display -->
                        <div id="car-hire-price-display"
                            class="hidden mt-4 p-3 bg-gradient-to-br from-teal-50 to-cyan-50 border border-teal-200 rounded-lg">
                            <div class="flex items-center mb-2">
                                <div class="p-1.5 bg-teal-100 rounded mr-2 border border-teal-200">
                                    <svg class="w-3 h-3 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                </div>
                                <h5 class="text-xs font-bold text-teal-800">Rental Pricing</h5>
                            </div>
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Per day:</span>
                                    <span id="car-hire-price-per-day" class="font-semibold text-teal-600"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span id="car-hire-duration" class="text-gray-700"></span>
                                </div>
                                <div class="border-t border-teal-200 pt-1 mt-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-700">Total:</span>
                                        <span id="car-hire-total-price" class="text-lg font-bold text-teal-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contact & Driver Information -->
                    <div
                        class="bg-gradient-to-br from-cyan-50 to-teal-50 rounded-xl p-5 border border-cyan-200 shadow-md">
                        <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
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
                                <label for="car_hire_customer_name"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="car_hire_customer_name" name="customer_name"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                            </div>

                            <div>
                                <label for="car_hire_customer_email"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="car_hire_customer_email" name="customer_email"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">For booking confirmations</p>
                            </div>

                            <div>
                                <label for="car_hire_customer_phone"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="car_hire_customer_phone" name="customer_phone"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    placeholder="+254 7XX XXX XXX" required>
                            </div>

                            <div>
                                <label for="drivers_license_number"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Driver's License <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="drivers_license_number" name="drivers_license_number"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    placeholder="License number" required>
                                <p class="text-xs text-gray-500 mt-1">Valid license required</p>
                            </div>

                            <div>
                                <label for="car_hire_special_requirements"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Special Requirements
                                </label>
                                <textarea id="car_hire_special_requirements" name="special_requirements" rows="3"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    placeholder="Any special requests..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account & Additional Info -->
                    <div
                        class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-xl p-5 border border-teal-200 shadow-md">
                        <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-teal-100 rounded-lg mr-2 border border-teal-200">
                                <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Account Setup
                        </h4>

                        <div class="space-y-4">
                            <div>
                                <label for="car_hire_password" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="car_hire_password" name="password"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required minlength="4">
                                <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                            </div>

                            <div>
                                <label for="car_hire_password_confirmation"
                                    class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="car_hire_password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:ring-teal-600 focus:border-teal-600"
                                    required minlength="4">
                                <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                            </div>
                        </div>

                        <!-- Car Hire Benefits -->
                        <div
                            class="mt-6 p-4 bg-gradient-to-br from-teal-50 to-cyan-50 border border-teal-200 rounded-lg">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-teal-100 rounded mr-2 border border-teal-200">
                                    <svg class="w-3 h-3 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h5 class="text-xs font-bold text-teal-800">Car Hire Benefits</h5>
                            </div>
                            <ul class="text-xs text-gray-600 space-y-1.5">
                                <li class="flex items-start">
                                    <svg class="w-3 h-3 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    24/7 roadside assistance
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-3 h-3 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Full insurance coverage included
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-3 h-3 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Flexible cancellation policy
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-3 h-3 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Unlimited mileage options
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-3 h-3 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    GPS navigation available
                                </li>
                            </ul>
                        </div>

                        <!-- Terms Notice -->
                        <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <p class="text-xs text-amber-800">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                By booking, you agree to our rental terms and conditions.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
                    <button type="button" id="cancel-car-hire-booking"
                        class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-8 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
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