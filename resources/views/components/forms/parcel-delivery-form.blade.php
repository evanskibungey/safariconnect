<!-- Parcel Delivery Inline Booking Form -->
<div id="parcel-delivery-form-container" class="hidden mt-8 animate-fade-in">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-orange-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white drop-shadow-sm">Book Your Parcel Delivery</h3>
                    </div>
                    <button id="close-parcel-delivery-form" 
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Body -->
            <form id="parcel-delivery-form" class="px-6 py-5">
                @csrf

                <!-- Form Content in 3 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                    <!-- Column 1: Parcel & Route Details -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-5 border border-gray-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-orange-100 rounded-lg mr-2 border border-orange-200">
                                <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                    </path>
                                </svg>
                            </div>
                            Parcel & Route Details
                        </h4>

                        <div class="space-y-4">
                            <!-- Route Selection -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="parcel_pickup_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="parcel_pickup_city" name="pickup_city_id"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select pickup city</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="parcel_dropoff_city" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Delivery City <span class="text-red-500">*</span>
                                    </label>
                                    <select id="parcel_dropoff_city" name="dropoff_city_id"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                        required>
                                        <option value="">Select delivery city</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Parcel Type Selection -->
                            <div>
                                <label for="parcel_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Parcel Type <span class="text-red-500">*</span>
                                </label>
                                <select id="parcel_type" name="parcel_type_id"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                    required>
                                    <option value="">Loading parcel types...</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Choose based on package size and weight
                                </p>
                                <!-- Admin Configuration Notice (will be shown if needed) -->
                                <div id="parcel-type-notice" class="hidden mt-2"></div>
                            </div>

                            <!-- Parcel Weight -->
                            <div>
                                <label for="parcel_weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Parcel Weight (kg) <span class="text-gray-500">(Optional)</span>
                                </label>
                                <input type="number" id="parcel_weight" name="parcel_weight" step="0.1" min="0.1"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                    placeholder="0.0">
                                <p class="text-xs text-gray-500 mt-1">Leave blank if unknown - pricing based on parcel type</p>
                            </div>

                            <!-- Delivery Date and Time -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="parcel_pickup_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="parcel_pickup_date" name="pickup_date"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="parcel_pickup_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Pickup Time <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="parcel_pickup_time" name="pickup_time"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                        required>
                                </div>
                            </div>

                            <!-- Parcel Description -->
                            <div>
                                <label for="parcel_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Parcel Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="parcel_description" name="parcel_description" rows="3"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none"
                                    placeholder="Describe your parcel contents..." required></textarea>
                                <p class="text-xs text-gray-500 mt-1">Helps us handle your parcel appropriately</p>
                            </div>

                            <!-- Price Display -->
                            <div id="parcel-price-display" class="hidden">
                                <div class="bg-gradient-to-br from-orange-50 via-red-50 to-orange-50 border border-orange-200 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-orange-100 rounded mr-2 border border-orange-200">
                                            <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h5 class="text-sm font-bold text-orange-800">Delivery Pricing</h5>
                                    </div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-700">Total Price:</span>
                                        <span id="parcel-price-amount" class="text-xl font-bold text-orange-600"></span>
                                    </div>
                                    <div id="parcel-price-breakdown" class="text-xs text-gray-600 bg-orange-50 px-3 py-2 rounded-lg">
                                        <!-- Price breakdown will be shown here -->
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Admin Configuration Notice -->
                            <div id="parcel-config-notice" class="hidden">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-start">
                                        <div class="p-1.5 bg-yellow-100 rounded mr-2 border border-yellow-200 flex-shrink-0">
                                            <svg class="w-3 h-3 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="text-xs font-semibold text-yellow-800">Configuration Required</h6>
                                            <p id="parcel-config-message" class="text-xs text-yellow-700 mt-1"></p>
                                            <a id="parcel-config-link" href="/admin/transportation/pricing" target="_blank" class="inline-flex items-center text-xs text-yellow-800 hover:text-yellow-900 underline mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Configure in Admin Panel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Sender & Recipient Information -->
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl p-5 border border-red-200 shadow-md">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <div class="p-2 bg-red-100 rounded-lg mr-2 border border-red-200">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            Sender & Recipient Details
                        </h4>

                        <div class="space-y-4">
                            <!-- Sender Information -->
                            <div class="bg-white/70 p-4 rounded-lg border border-red-100">
                                <h5 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Sender Information
                                </h5>
                                <div class="space-y-3">
                                    <div>
                                        <label for="parcel_customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Sender Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="parcel_customer_name" name="customer_name"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                            required>
                                    </div>

                                    <div>
                                        <label for="parcel_customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Sender Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="parcel_customer_email" name="customer_email"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                            required>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            For account and tracking updates
                                        </p>
                                    </div>

                                    <div>
                                        <label for="parcel_customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Sender Phone <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="parcel_customer_phone" name="customer_phone"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                            placeholder="+254 7XX XXX XXX" required>
                                    </div>

                                    <div>
                                        <label for="sender_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Pickup Address <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="sender_address" name="sender_address" rows="2"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 resize-none"
                                            placeholder="Full pickup address..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Recipient Information -->
                            <div class="bg-white/70 p-4 rounded-lg border border-red-100">
                                <h5 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                    Recipient Information
                                </h5>
                                <div class="space-y-3">
                                    <div>
                                        <label for="recipient_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Recipient Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="recipient_name" name="recipient_name"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200"
                                            required>
                                    </div>

                                    <div>
                                        <label for="recipient_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Recipient Phone <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="recipient_phone" name="recipient_phone"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200"
                                            placeholder="+254 7XX XXX XXX" required>
                                    </div>

                                    <div>
                                        <label for="recipient_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Delivery Address <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="recipient_address" name="recipient_address" rows="2"
                                            class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 resize-none"
                                            placeholder="Full delivery address..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Account Setup & Additional Options -->
                    <div class="space-y-5">
                        <!-- Password Section -->
                        <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-5 border border-pink-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-pink-100 rounded-lg mr-2 border border-pink-200">
                                    <svg class="w-4 h-4 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Account Password
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <label for="parcel_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="parcel_password" name="password"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                </div>

                                <div>
                                    <label for="parcel_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" id="parcel_password_confirmation" name="password_confirmation"
                                        class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200"
                                        required minlength="4">
                                    <p class="text-xs text-gray-500 mt-1">Re-enter password</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Instructions Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200 shadow-md">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-2 border border-purple-200">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                Special Instructions
                            </h4>

                            <div>
                                <label for="special_instructions" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Additional Notes (Optional)
                                </label>
                                <textarea id="special_instructions" name="special_instructions" rows="4"
                                    class="w-full px-3 py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 resize-none"
                                    placeholder="Any special handling or delivery instructions..."></textarea>
                            </div>

                            <!-- Delivery Benefits -->
                            <div class="mt-4 p-4 bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 rounded-lg">
                                <div class="flex items-center mb-3">
                                    <div class="p-2 bg-orange-100 rounded mr-2 border border-orange-200">
                                        <svg class="w-3 h-3 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h5 class="text-sm font-bold text-orange-800">Delivery Benefits</h5>
                                </div>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Real-time tracking
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        SMS & email updates
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Secure handling
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Professional couriers
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-parcel-delivery-booking"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-orange-600 via-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:via-red-700 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-md font-medium text-sm">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Book Parcel Delivery
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
