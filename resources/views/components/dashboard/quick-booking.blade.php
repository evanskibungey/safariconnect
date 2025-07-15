<!-- Quick Booking Dashboard Component for Authenticated Users -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
        <h3 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
            </svg>
            Quick Booking - No Personal Info Needed!
        </h3>
        <p class="text-orange-100 text-sm mt-1">
            Your details are auto-filled for instant booking
        </p>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Shared Ride Quick Book -->
            <a href="{{ url('/') }}#shared-ride-card"
                class="group relative p-5 bg-gradient-to-br from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-orange-600 uppercase tracking-wider">Starting from</div>
                            <div class="text-lg font-bold text-orange-700">KSh 1,500</div>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">Shared Ride</h4>
                    <p class="text-sm text-gray-600 mb-2">Cost-effective travel with other passengers</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Save up to 50%
                    </div>
                </div>
            </a>

            <!-- Solo Ride Quick Book -->
            <a href="{{ url('/') }}#solo-ride-card"
                class="group relative p-5 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-blue-600 uppercase tracking-wider">Starting from</div>
                            <div class="text-lg font-bold text-blue-700">KSh 2,500</div>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">Solo Ride</h4>
                    <p class="text-sm text-gray-600 mb-2">Private transportation just for you</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Privacy & comfort
                    </div>
                </div>
            </a>

            <!-- Airport Transfer Quick Book -->
            <a href="{{ url('/') }}#airport-transfer-card"
                class="group relative p-5 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-green-600 uppercase tracking-wider">Starting from</div>
                            <div class="text-lg font-bold text-green-700">KSh 3,000</div>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">Airport Transfer</h4>
                    <p class="text-sm text-gray-600 mb-2">Reliable transfers to/from airports</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        On-time guarantee
                    </div>
                </div>
            </a>

            <!-- Car Hire Quick Book -->
            <a href="{{ url('/') }}#car-hire-card"
                class="group relative p-5 bg-gradient-to-br from-purple-50 to-violet-50 border-2 border-purple-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-violet-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-violet-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-purple-600 uppercase tracking-wider">Starting from</div>
                            <div class="text-lg font-bold text-purple-700">KSh 2,500/day</div>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">Car Hire</h4>
                    <p class="text-sm text-gray-600 mb-2">Self-drive vehicles for extended trips</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Freedom & flexibility
                    </div>
                </div>
            </a>

            <!-- Parcel Delivery Quick Book -->
            <a href="{{ url('/') }}#parcel-delivery-card"
                class="group relative p-5 bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-yellow-600 uppercase tracking-wider">Starting from</div>
                            <div class="text-lg font-bold text-yellow-700">KSh 500</div>
                        </div>
                    </div>
                    <h4 class="text-base font-bold text-gray-800 mb-1">Parcel Delivery</h4>
                    <p class="text-sm text-gray-600 mb-2">Fast and secure package delivery</p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Track & trace
                    </div>
                </div>
            </a>
        </div>

        <!-- Pro Tip -->
        <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-semibold text-blue-800">💡 Pro Tip</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        As a registered user, your name, email, and phone are automatically filled in all booking forms. 
                        Just select your trip details and you're ready to go!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
