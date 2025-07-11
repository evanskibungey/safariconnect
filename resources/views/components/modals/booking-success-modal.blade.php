<!-- Booking Success Modal -->
<div id="booking-success-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm"></div>
        </div>

        <!-- Modal panel - Horizontal Layout -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-5xl w-full mx-auto transform transition-all">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-green-700 px-8 py-6 rounded-t-2xl">
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white/20 backdrop-blur-sm mr-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-white mb-1" id="success-title">
                            Booking Successful!
                        </h3>
                        <p class="text-white/90" id="success-subtitle">
                            Your booking has been confirmed
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content - Horizontal Layout -->
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Booking Reference & Key Details -->
                    <div class="lg:col-span-1">
                        <!-- Booking Reference -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-6 border border-gray-200">
                            <div class="text-center">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Booking Reference</p>
                                <p class="text-2xl font-bold text-gray-900 font-mono" id="booking-reference">--</p>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div id="account-status" class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 hidden">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-semibold text-blue-800" id="account-message">
                                        Your SafariConnect account has been created!
                                    </p>
                                    <p class="text-xs text-blue-600 mt-1" id="account-email">
                                        Login email: --
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Column: Service Details -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-6 border border-orange-200 h-full">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3 border border-orange-200">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Booking Details
                            </h4>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-orange-100">
                                    <span class="text-sm font-medium text-gray-600">Service</span>
                                    <span class="text-sm font-bold text-gray-900" id="service-type">--</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-orange-100">
                                    <span class="text-sm font-medium text-gray-600">Route</span>
                                    <span class="text-sm font-bold text-gray-900 text-right" id="route-info">--</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-orange-100">
                                    <span class="text-sm font-medium text-gray-600">Travel Date</span>
                                    <span class="text-sm font-bold text-gray-900 text-right" id="travel-info">--</span>
                                </div>
                                <div class="flex justify-between items-center py-3 bg-green-50 rounded-lg px-3 mt-4">
                                    <span class="text-sm font-semibold text-gray-700">Total Amount</span>
                                    <span class="text-lg font-bold text-green-600" id="total-amount">--</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Next Steps -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200 h-full">
                            <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3 border border-purple-200">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                What's Next?
                            </h4>
                            
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 border-2 border-green-200">
                                            <span class="text-xs font-bold text-green-600">1</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">Email Confirmation</p>
                                        <p class="text-xs text-gray-600 mt-1">Booking details sent to your email</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 border-2 border-blue-200">
                                            <span class="text-xs font-bold text-blue-600">2</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">Driver Assignment</p>
                                        <p class="text-xs text-gray-600 mt-1">Contact details will be shared</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-purple-100 border-2 border-purple-200">
                                            <span class="text-xs font-bold text-purple-600">3</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">Track Progress</p>
                                        <p class="text-xs text-gray-600 mt-1">Monitor from your dashboard</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Full Width -->
            <div class="px-8 pb-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" id="view-dashboard-btn" 
                        class="flex-1 bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 hover:from-orange-700 hover:via-amber-700 hover:to-orange-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        View Dashboard
                    </button>
                    <button type="button" id="book-another-btn" 
                        class="flex-1 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Book Another
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>