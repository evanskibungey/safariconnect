<x-app-layout>
    <x-slot name="header">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-2xl shadow-xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 px-6 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white mb-1">
                            Welcome back, {{ auth()->user()->name }}! 👋
                        </h2>
                        <p class="text-orange-100 text-lg">
                            Your journey starts here - manage bookings and track your adventures
                        </p>
                    </div>
                    <a href="{{ url('/') }}"
                        class="group bg-white/20 backdrop-blur-md hover:bg-white/30 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-2xl hover:scale-105 border border-white/30">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Book New Ride</span>
                    </a>
                </div>
            </div>

            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full blur-2xl -ml-24 -mb-24"></div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- New Booking Success Alert (if redirected from booking) -->
            @if(session('booking_success'))
            <div
                class="relative bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl p-6 shadow-xl overflow-hidden">
                <div class="absolute inset-0 bg-white/20"></div>
                <div class="relative z-10 flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-bold text-white">
                            Booking Confirmed Successfully! 🎉
                        </h3>
                        <div class="mt-2 text-green-50">
                            <p>Your booking reference is: <span
                                    class="font-bold bg-white/20 px-2 py-1 rounded">{{ session('booking_reference') }}</span>
                            </p>
                            <p class="mt-1">{{ session('booking_message') }}</p>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button type="button"
                            class="bg-white/20 hover:bg-white/30 rounded-lg p-2 inline-flex text-white transition-colors"
                            onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Booking for Authenticated Users -->
            @include('components.dashboard.quick-booking')

            <!-- Account Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Bookings Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bookings</p>
                                <p
                                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                                    {{ auth()->user()->bookings()->count() }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-blue-600 font-semibold">+12%</span> from last month
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Completed Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-green-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</p>
                                <p
                                    class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                    {{ auth()->user()->bookings()->where('status', 'completed')->count() }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                <span class="text-green-600 font-semibold">100%</span> success rate
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-orange-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Upcoming</p>
                                <p
                                    class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-700 bg-clip-text text-transparent">
                                    {{ auth()->user()->bookings()->upcoming()->count() }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                Next trip in <span class="text-orange-600 font-semibold">3 days</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Spent Card -->
                <div
                    class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</p>
                                <p
                                    class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent">
                                    KSh {{ number_format(auth()->user()->bookings()->sum('total_price'), 0) }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-600">
                                Average <span class="text-purple-600 font-semibold">KSh 3,500</span> per trip
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ url('/') }}#shared-ride-card"
                            class="group relative p-6 bg-gradient-to-br from-orange-50 to-red-50 border-2 border-orange-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-400 opacity-0 group-hover:opacity-10 transition-opacity">
                            </div>
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center mb-3 shadow-lg group-hover:shadow-xl transition-shadow">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                    </svg>
                                </div>
                                <span class="text-base font-bold text-gray-800 group-hover:text-orange-700">Shared
                                    Ride</span>
                                <span class="text-xs text-gray-600 mt-1">Save up to 50%</span>
                            </div>
                        </a>

                        <a href="{{ url('/') }}#solo-ride-card"
                            class="group relative p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-400 opacity-0 group-hover:opacity-10 transition-opacity">
                            </div>
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center mb-3 shadow-lg group-hover:shadow-xl transition-shadow">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z" />
                                    </svg>
                                </div>
                                <span class="text-base font-bold text-gray-800 group-hover:text-blue-700">Solo
                                    Ride</span>
                                <span class="text-xs text-gray-600 mt-1">Private & comfortable</span>
                            </div>
                        </a>

                        <a href="{{ url('/') }}#airport-transfer-card"
                            class="group relative p-6 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-400 opacity-0 group-hover:opacity-10 transition-opacity">
                            </div>
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center mb-3 shadow-lg group-hover:shadow-xl transition-shadow">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                    </svg>
                                </div>
                                <span class="text-base font-bold text-gray-800 group-hover:text-green-700">Airport
                                    Transfer</span>
                                <span class="text-xs text-gray-600 mt-1">On-time guarantee</span>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="group relative p-6 bg-gradient-to-br from-purple-50 to-violet-50 border-2 border-purple-200 rounded-xl hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-purple-400 to-violet-400 opacity-0 group-hover:opacity-10 transition-opacity">
                            </div>
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-purple-400 to-violet-500 rounded-2xl flex items-center justify-center mb-3 shadow-lg group-hover:shadow-xl transition-shadow">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-base font-bold text-gray-800 group-hover:text-purple-700">Edit
                                    Profile</span>
                                <span class="text-xs text-gray-600 mt-1">Update your info</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Active Bookings -->
            @php
            $activeBookings = auth()->user()->bookings()
            ->with(['transportationService', 'pickupCity', 'dropoffCity', 'pickupAirport', 'dropoffAirport',
            'vehicleType', 'driver'])
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->orderBy('travel_date', 'asc')
            ->get();
            @endphp

            @if($activeBookings->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Active Bookings
                        </h3>
                        <span
                            class="bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $activeBookings->count() }} booking(s)
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    @foreach($activeBookings as $booking)
                    <div class="relative rounded-xl p-6 border-2 transition-all duration-300 hover:shadow-lg
                                @if($booking->status === 'pending') bg-yellow-50 border-yellow-300 hover:border-yellow-400
                                @elseif($booking->status === 'confirmed') bg-blue-50 border-blue-300 hover:border-blue-400
                                @elseif($booking->status === 'in_progress') bg-green-50 border-green-300 hover:border-green-400
                                @endif">
                        <div class="absolute top-0 left-0 w-1 h-full rounded-l-xl
                                    @if($booking->status === 'pending') bg-yellow-400
                                    @elseif($booking->status === 'confirmed') bg-blue-400
                                    @elseif($booking->status === 'in_progress') bg-green-400
                                    @endif"></div>

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <span
                                        class="text-lg font-bold text-gray-900 mr-3">{{ $booking->booking_reference }}</span>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wider
                                                @if($booking->status === 'pending') bg-yellow-200 text-yellow-800
                                                @elseif($booking->status === 'confirmed') bg-blue-200 text-blue-800
                                                @elseif($booking->status === 'in_progress') bg-green-200 text-green-800
                                                @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <p class="text-base text-gray-800 font-medium">
                                        <span class="text-gray-600">Service:</span>
                                        {{ $booking->transportationService->name }}
                                    </p>
                                    <p class="text-base text-gray-700 flex items-start">
                                        <svg class="w-5 h-5 mr-2 text-gray-500 flex-shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $booking->route_description }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-4 text-sm">
                                        <span class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $booking->travel_date->format('M d, Y') }}
                                        </span>
                                        <span class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $booking->travel_time }}
                                        </span>
                                        <span class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            {{ $booking->passengers }} passenger(s)
                                        </span>
                                        <span class="flex items-center font-bold text-gray-900">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            KSh {{ number_format($booking->total_price, 2) }}
                                        </span>
                                    </div>

                                    @if($booking->driver)
                                    <div class="mt-3 p-3 bg-white/70 rounded-lg flex items-center">
                                        <svg class="w-10 h-10 mr-3 text-blue-500" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $booking->driver->name }}
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $booking->driver->phone }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('booking.details', $booking->id) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    View Details
                                </a>
                                @if($booking->status === 'pending')
                                <button
                                    class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Cancel
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent Bookings -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Recent Bookings
                        </h3>
                        <a href="{{ route('booking.history') }}"
                            class="inline-flex items-center text-orange-500 hover:text-orange-600 text-sm font-semibold transition-colors">
                            View All History
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                @php
                $recentBookings = auth()->user()->bookings()
                ->with(['transportationService', 'pickupCity', 'dropoffCity'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                @endphp

                @if($recentBookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Booking Ref
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Service
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Route
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Travel Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm font-bold text-gray-900">{{ $booking->booking_reference }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm text-gray-700 font-medium">{{ $booking->transportationService->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $booking->route_description }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="text-sm text-gray-700">{{ $booking->travel_date->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full
                                        @if($booking->status === 'completed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">KSh
                                        {{ number_format($booking->total_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('booking.details', $booking->id) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(auth()->user()->bookings()->count() > 5)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600 text-center">
                        Showing 5 of {{ auth()->user()->bookings()->count() }} total bookings.
                        <a href="{{ route('booking.history') }}"
                            class="text-orange-500 hover:text-orange-600 font-semibold ml-1">View all →</a>
                    </p>
                </div>
                @endif
                @else
                <div class="p-12 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No bookings yet</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Start your journey with SafariConnect! Book your first ride and experience comfortable, reliable
                        transportation.
                    </p>
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path
                                d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z" />
                        </svg>
                        Book Your First Ride
                    </a>
                </div>
                @endif
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd" />
                            </svg>
                            Account Information
                        </h3>
                        <a href="{{ route('profile.edit') }}"
                            class="inline-flex items-center bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Full Name</label>
                            <p class="text-base text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Email Address</label>
                            <p class="text-base text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Phone Number</label>
                            <p class="text-base text-gray-900 font-medium">{{ auth()->user()->phone ?? 'Not provided' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Member Since</label>
                            <p class="text-base text-gray-900 font-medium">
                                {{ auth()->user()->created_at->format('F Y') }}</p>
                        </div>
                    </div>

                    <div
                        class="mt-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-purple-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Account Verified</h4>
                                <p class="text-sm text-gray-600">Your account is fully verified and ready for all
                                    services.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>