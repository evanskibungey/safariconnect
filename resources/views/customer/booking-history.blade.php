<x-app-layout>
    <x-slot name="header">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 px-6 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white mb-1">
                            Booking History 📚
                        </h2>
                        <p class="text-indigo-100 text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            View and manage all your travel adventures
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('dashboard') }}"
                            class="group bg-white/20 backdrop-blur-md hover:bg-white/30 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-2xl hover:scale-105 border border-white/30">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                            <span class="font-semibold">Dashboard</span>
                        </a>
                        <a href="{{ url('/') }}"
                            class="group bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-2xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">New Booking</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full blur-2xl -ml-24 -mb-24"></div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Enhanced Filters and Search -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-8 py-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Search & Filter Bookings
                    </h3>
                </div>

                <div class="p-8">
                    <form method="GET" action="{{ route('booking.history') }}" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Search by Reference -->
                            <div class="md:col-span-1">
                                <label for="search"
                                    class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Search by Reference
                                </label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Enter booking reference..."
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            </div>

                            <!-- Filter by Status -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Status
                                </label>
                                <select id="status" name="status"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gradient-to-r from-green-50 to-emerald-50">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter by Service -->
                            <div>
                                <label for="service"
                                    class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                        </path>
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z">
                                        </path>
                                    </svg>
                                    Service Type
                                </label>
                                <select id="service" name="service"
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gradient-to-r from-purple-50 to-violet-50">
                                    <option value="">All Services</option>
                                    @foreach($serviceTypes as $value => $label)
                                    <option value="{{ $value }}" {{ request('service') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="group bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105 flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Apply Filters
                            </button>
                            <a href="{{ route('booking.history') }}"
                                class="group bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-md hover:shadow-lg hover:scale-105 flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-300"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Bookings -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-4xl font-black bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                                    {{ $bookings->total() }}
                                </p>
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Total Bookings</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-blue-600 font-semibold">Your travel history</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-green-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-4xl font-black bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                    {{ auth()->user()->bookings()->where('status', 'completed')->count() }}
                                </p>
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Completed</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-green-600 font-semibold">Successful trips</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pending Bookings -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-orange-500/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-4xl font-black bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">
                                    {{ auth()->user()->bookings()->where('status', 'pending')->count() }}
                                </p>
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Pending</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-orange-600 font-semibold">Awaiting confirmation</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p
                                    class="text-3xl font-black bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent">
                                    KSh {{ number_format(auth()->user()->bookings()->sum('total_price'), 0) }}
                                </p>
                                <p class="text-sm font-bold text-gray-600 uppercase tracking-wider">Total Spent</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-purple-600 font-semibold">Lifetime value</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Bookings List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Your Bookings
                    </h3>
                </div>

                <div class="p-8">
                    @if($bookings->count() > 0)
                    <!-- Enhanced Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Reference</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Service</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Route</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Travel Date</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($bookings as $booking)
                                <tr
                                    class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $booking->booking_reference }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $booking->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $booking->transportationService->name }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                                </path>
                                            </svg>
                                            {{ $booking->passengers }} passenger(s)
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate">
                                            {{ $booking->route_description }}</div>
                                        @if($booking->driver)
                                        <div class="text-xs text-blue-600 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $booking->driver->name }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $booking->travel_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $booking->travel_time }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-2 inline-flex text-xs leading-5 font-bold rounded-full shadow-md uppercase tracking-wider
                                                    @if($booking->status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                                                    @elseif($booking->status === 'confirmed') bg-gradient-to-r from-blue-500 to-blue-600 text-white
                                                    @elseif($booking->status === 'in_progress') bg-gradient-to-r from-purple-500 to-purple-600 text-white
                                                    @elseif($booking->status === 'completed') bg-gradient-to-r from-green-500 to-green-600 text-white
                                                    @elseif($booking->status === 'cancelled') bg-gradient-to-r from-red-500 to-red-600 text-white
                                                    @else bg-gradient-to-r from-gray-500 to-gray-600 text-white
                                                    @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                        @if($booking->payment_status === 'paid')
                                        <div class="text-xs text-green-600 font-semibold mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Paid
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        KSh {{ number_format($booking->total_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('booking.details', $booking) }}"
                                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105">
                                            View
                                        </a>
                                        @if($booking->driver && ($booking->status === 'confirmed' || $booking->status
                                        === 'in_progress'))
                                        <a href="tel:{{ $booking->driver->phone }}"
                                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105">
                                            Call
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Enhanced Mobile Card View -->
                    <div class="lg:hidden space-y-6">
                        @foreach($bookings as $booking)
                        <div class="relative bg-gradient-to-r from-white to-gray-50 rounded-2xl p-6 border-l-4 shadow-lg hover:shadow-xl transition-all duration-300
                                    @if($booking->status === 'pending') border-yellow-400
                                    @elseif($booking->status === 'confirmed') border-blue-400
                                    @elseif($booking->status === 'in_progress') border-purple-400
                                    @elseif($booking->status === 'completed') border-green-600
                                    @elseif($booking->status === 'cancelled') border-red-400
                                    @endif">

                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $booking->booking_reference }}</h4>
                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $booking->created_at->format('M d, Y \a\t g:i A') }}
                                    </p>
                                </div>
                                <span class="px-3 py-2 text-xs font-bold rounded-full shadow-lg uppercase tracking-wider
                                            @if($booking->status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                                            @elseif($booking->status === 'confirmed') bg-gradient-to-r from-blue-500 to-blue-600 text-white
                                            @elseif($booking->status === 'in_progress') bg-gradient-to-r from-purple-500 to-purple-600 text-white
                                            @elseif($booking->status === 'completed') bg-gradient-to-r from-green-500 to-green-600 text-white
                                            @elseif($booking->status === 'cancelled') bg-gradient-to-r from-red-500 to-red-600 text-white
                                            @else bg-gradient-to-r from-gray-500 to-gray-600 text-white
                                            @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="bg-white p-4 rounded-xl shadow-sm">
                                    <p class="text-sm font-bold text-gray-900 mb-1">
                                        {{ $booking->transportationService->name }}</p>
                                    <p class="text-sm text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $booking->route_description }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-blue-50 p-3 rounded-xl border border-blue-200">
                                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Travel
                                            Date</p>
                                        <p class="text-sm font-bold text-gray-900">
                                            {{ $booking->travel_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-600">{{ $booking->travel_time }}</p>
                                    </div>

                                    <div class="bg-green-50 p-3 rounded-xl border border-green-200">
                                        <p class="text-xs font-semibold text-green-600 uppercase tracking-wider">Amount
                                        </p>
                                        <p class="text-lg font-black text-gray-900">KSh
                                            {{ number_format($booking->total_price, 2) }}</p>
                                        @if($booking->payment_status === 'paid')
                                        <p class="text-xs text-green-600 font-semibold">✓ Paid</p>
                                        @endif
                                    </div>
                                </div>

                                @if($booking->driver)
                                <div class="bg-purple-50 p-3 rounded-xl border border-purple-200">
                                    <p
                                        class="text-xs font-semibold text-purple-600 uppercase tracking-wider flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Driver Assigned
                                    </p>
                                    <p class="text-sm font-bold text-gray-900">{{ $booking->driver->name }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('booking.details', $booking) }}"
                                    class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm px-4 py-3 rounded-xl transition-all duration-200 font-semibold text-center shadow-lg hover:shadow-xl">
                                    View Details
                                </a>
                                @if($booking->driver && ($booking->status === 'confirmed' || $booking->status ===
                                'in_progress'))
                                <a href="tel:{{ $booking->driver->phone }}"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm px-4 py-3 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                        </path>
                                    </svg>
                                    Call
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Pagination -->
                    <div class="mt-8 flex justify-center">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-4 shadow-lg">
                            {{ $bookings->withQueryString()->links() }}
                        </div>
                    </div>
                    @else
                    <!-- Enhanced Empty State -->
                    <div class="text-center py-16">
                        <div
                            class="w-32 h-32 mx-auto mb-8 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">No bookings found</h3>
                        @if(request()->hasAny(['search', 'status', 'service']))
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">No bookings match your current search criteria.
                            Try adjusting your filters or search terms.</p>
                        <a href="{{ route('booking.history') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Clear All Filters
                        </a>
                        @else
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't made any bookings yet. Start your
                            journey with SafariConnect and create your first booking!</p>
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-xl transition-all duration-200 shadow-xl hover:shadow-2xl hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Book Your First Ride
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>