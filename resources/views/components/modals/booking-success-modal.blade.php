<!-- Booking Success Modal -->
<div id="booking-success-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900/75 backdrop-blur-sm"></div>
        </div>

        <!-- Modal panel -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto transform transition-all">
            <!-- Success Icon -->
            <div class="pt-8 pb-4 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2" id="success-title">
                    Booking Successful!
                </h3>
                <p class="text-sm text-gray-600" id="success-subtitle">
                    Your booking has been confirmed
                </p>
            </div>

            <!-- Booking Details -->
            <div class="px-6 pb-4">
                <!-- Booking Reference -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="text-center">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Booking Reference</p>
                        <p class="text-xl font-bold text-gray-900" id="booking-reference">--</p>
                    </div>
                </div>

                <!-- Service Details -->
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Service</span>
                        <span class="text-sm font-semibold text-gray-900" id="service-type">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Route</span>
                        <span class="text-sm font-semibold text-gray-900" id="route-info">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Travel Date</span>
                        <span class="text-sm font-semibold text-gray-900" id="travel-info">--</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Total Amount</span>
                        <span class="text-sm font-bold text-green-600" id="total-amount">--</span>
                    </div>
                </div>

                <!-- Account Status -->
                <div id="account-status" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800" id="account-message">
                                Your SafariConnect account has been created!
                            </p>
                            <p class="text-xs text-blue-600" id="account-email">
                                Login email: --
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-6">
                    <h4 class="text-sm font-medium text-orange-800 mb-2">What happens next?</h4>
                    <ul class="text-xs text-orange-700 space-y-1">
                        <li class="flex items-center">
                            <svg class="w-3 h-3 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            We'll send confirmation details to your email
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Driver assignment and contact details
                        </li>
                        <li class="flex items-center">
                            <svg class="w-3 h-3 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Track your booking from your dashboard
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 pb-6 flex space-x-3">
                <button type="button" id="view-dashboard-btn" 
                    class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    View Dashboard
                </button>
                <button type="button" id="book-another-btn" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Book Another
                </button>
            </div>
        </div>
    </div>
</div>