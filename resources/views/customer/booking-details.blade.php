<x-app-layout>
    <x-slot name="header">
        <div
            class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 rounded-2xl shadow-xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative z-10 px-6 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white mb-1">
                            Booking Details 📋
                        </h2>
                        <p class="text-blue-100 text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Reference: <span
                                class="font-bold bg-white/20 px-2 py-1 rounded ml-1">{{ $booking->booking_reference }}</span>
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('booking.history') }}"
                            class="group bg-white/20 backdrop-blur-md hover:bg-white/30 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-2xl hover:scale-105 border border-white/30">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Back to History</span>
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="group bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-2xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                            <span class="font-semibold">Dashboard</span>
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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Booking Status Card -->
            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5"></div>
                <div class="relative z-10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <svg class="w-8 h-8 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Booking Status
                        </h3>
                        <span class="px-6 py-3 text-sm font-bold rounded-full shadow-lg uppercase tracking-wider
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

                    <!-- Enhanced Status Timeline -->
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <!-- Booking Submitted -->
                            <div class="flex flex-col items-center relative z-10">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300
                                    {{ $booking->status === 'pending' ? 'bg-gradient-to-r from-yellow-400 to-orange-400 text-white' : 'bg-gradient-to-r from-green-500 to-green-600 text-white' }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span
                                    class="text-xs font-semibold text-gray-700 mt-2 text-center">Booking<br>Submitted</span>
                            </div>

                            <!-- Confirmed -->
                            <div class="flex flex-col items-center relative z-10">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300
                                    {{ in_array($booking->status, ['confirmed', 'in_progress', 'completed']) ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'bg-gray-300 text-gray-500' }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Confirmed</span>
                            </div>

                            <!-- In Progress -->
                            <div class="flex flex-col items-center relative z-10">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300
                                    {{ in_array($booking->status, ['in_progress', 'completed']) ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white' : 'bg-gray-300 text-gray-500' }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                        </path>
                                        <path
                                            d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-700 mt-2 text-center">In Progress</span>
                            </div>

                            <!-- Completed -->
                            <div class="flex flex-col items-center relative z-10">
                                <div
                                    class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300
                                    {{ $booking->status === 'completed' ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' : 'bg-gray-300 text-gray-500' }}">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 12.586l-2.293-2.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs font-semibold text-gray-700 mt-2 text-center">Completed</span>
                            </div>
                        </div>

                        <!-- Progress Line -->
                        <div class="absolute top-6 left-6 right-6 h-1 bg-gray-200 rounded-full">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transition-all duration-1000 ease-out
                                @if($booking->status === 'pending') w-0
                                @elseif($booking->status === 'confirmed') w-1/3
                                @elseif($booking->status === 'in_progress') w-2/3
                                @elseif($booking->status === 'completed') w-full
                                @endif"></div>
                        </div>
                    </div>

                    <!-- Cancellation Status -->
                    @if($booking->status === 'cancelled')
                    <div class="mt-6 p-6 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-2xl">
                        <div class="flex items-start">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-red-800 mb-1">Booking Cancelled</h4>
                                @if($booking->cancelled_at)
                                <p class="text-sm text-red-700 mb-2">Cancelled on
                                    {{ $booking->cancelled_at->format('M d, Y \a\t g:i A') }}</p>
                                @endif
                                @if($booking->cancellation_reason)
                                <p class="text-sm text-red-700">
                                    <span class="font-semibold">Reason:</span> {{ $booking->cancellation_reason }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-wrap gap-3">
                        @if($booking->status === 'pending')
                        <button onclick="cancelBooking()"
                            class="group bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105 flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Cancel Booking
                        </button>
                        @endif
                        @if($booking->status === 'completed')
                        <button
                            class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105 flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            Rate Experience
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Service Details
                    </h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-xl border border-orange-200">
                            <label class="block text-sm font-bold text-orange-600 uppercase tracking-wider mb-2">Service
                                Type</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->transportationService->name }}
                            </p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                            <label class="block text-sm font-bold text-blue-600 uppercase tracking-wider mb-2">Booking
                                Reference</label>
                            <p
                                class="text-lg font-mono font-bold text-gray-900 bg-white px-3 py-2 rounded-lg shadow-inner">
                                {{ $booking->booking_reference }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                            <label
                                class="block text-sm font-bold text-green-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Route
                            </label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->route_description }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-r from-purple-50 to-violet-50 p-6 rounded-xl border border-purple-200">
                            <label
                                class="block text-sm font-bold text-purple-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Travel Date & Time
                            </label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->travel_date->format('l, F j, Y') }}
                            </p>
                            <p class="text-sm text-purple-600 font-medium mt-1">{{ $booking->travel_time }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-xl border border-yellow-200">
                            <label
                                class="block text-sm font-bold text-yellow-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                    </path>
                                </svg>
                                Passengers
                            </label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->passengers }} passenger(s)</p>
                        </div>

                        @if($booking->vehicleType)
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                            <label class="block text-sm font-bold text-indigo-600 uppercase tracking-wider mb-2">Vehicle
                                Type</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->vehicleType->name }}</p>
                        </div>
                        @endif

                        @if($booking->transfer_type)
                        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-6 rounded-xl border border-teal-200">
                            <label class="block text-sm font-bold text-teal-600 uppercase tracking-wider mb-2">Transfer
                                Type</label>
                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($booking->transfer_type) }}</p>
                        </div>
                        @endif

                        @if($booking->flight_number)
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-xl border border-pink-200">
                            <label
                                class="block text-sm font-bold text-pink-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                                    </path>
                                </svg>
                                Flight Number
                            </label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->flight_number }}</p>
                        </div>
                        @endif

                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-6 rounded-xl border border-gray-200">
                            <label class="block text-sm font-bold text-gray-600 uppercase tracking-wider mb-2">Booking
                                Created</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    @if($booking->special_requirements)
                    <div class="mt-8">
                        <label class="block text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Special Requirements
                        </label>
                        <div
                            class="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-2xl border-2 border-orange-200 shadow-inner">
                            @if($booking->transportationService->service_type === 'parcel_delivery' &&
                            $booking->parcel_info)
                            @php $parcelInfo = $booking->parcel_info; @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if(isset($parcelInfo->description))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Description:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->description }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->weight))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Weight:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->weight }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->type))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Type:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->type }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->sender_address))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Sender Address:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->sender_address }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->recipient_name))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Recipient:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->recipient_name }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->recipient_phone))
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <strong class="text-orange-600">Recipient Phone:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->recipient_phone }}</span>
                                </div>
                                @endif
                                @if(isset($parcelInfo->recipient_address))
                                <div class="bg-white p-4 rounded-lg shadow-sm col-span-full">
                                    <strong class="text-orange-600">Recipient Address:</strong>
                                    <span class="text-gray-900">{{ $parcelInfo->recipient_address }}</span>
                                </div>
                                @endif
                            </div>

                            @if(isset($parcelInfo->urgent) || isset($parcelInfo->signature_required) ||
                            isset($parcelInfo->insurance))
                            <div class="mt-4 flex flex-wrap gap-3">
                                @if(isset($parcelInfo->urgent))
                                <span
                                    class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    🚨 URGENT DELIVERY
                                </span>
                                @endif
                                @if(isset($parcelInfo->signature_required))
                                <span
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    ✍️ SIGNATURE REQUIRED
                                </span>
                                @endif
                                @if(isset($parcelInfo->insurance))
                                <span
                                    class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    🛡️ INSURANCE COVERAGE
                                </span>
                                @endif
                            </div>
                            @endif
                            @else
                            <div class="text-gray-900 leading-relaxed">
                                {!! nl2br(e($booking->special_requirements)) !!}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Driver Information -->
            @if($booking->driver)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Driver Information
                    </h3>
                </div>

                <div class="p-8">
                    <div
                        class="flex flex-col lg:flex-row items-start lg:items-center space-y-6 lg:space-y-0 lg:space-x-8">
                        <div
                            class="w-24 h-24 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-xl">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <div class="flex-1">
                            <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $booking->driver->name }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                                    <p class="text-sm font-semibold text-green-600 uppercase tracking-wider">Phone</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $booking->driver->phone }}</p>
                                </div>

                                @if($booking->driver->vehicle_details)
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                    <p class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Vehicle</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $booking->driver->vehicle_details }}
                                    </p>
                                </div>
                                @endif

                                @if($booking->driver->vehicle_registration)
                                <div
                                    class="bg-gradient-to-r from-purple-50 to-violet-50 p-4 rounded-xl border border-purple-200">
                                    <p class="text-sm font-semibold text-purple-600 uppercase tracking-wider">Plate
                                        Number</p>
                                    <p class="text-lg font-bold text-gray-900 font-mono">
                                        {{ $booking->driver->vehicle_registration }}</p>
                                </div>
                                @endif
                            </div>

                            @if($booking->driver->rating && $booking->driver->total_trips > 0)
                            <div
                                class="mt-4 bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-xl border border-yellow-200">
                                <div class="flex items-center">
                                    <span
                                        class="text-sm font-semibold text-yellow-600 uppercase tracking-wider mr-3">Rating:</span>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++) <svg
                                            class="w-5 h-5 {{ $i <= $booking->driver->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                            </svg>
                                            @endfor
                                            <span
                                                class="ml-2 text-lg font-bold text-gray-900">{{ number_format($booking->driver->rating, 1) }}</span>
                                            <span
                                                class="ml-1 text-sm text-gray-600">({{ $booking->driver->total_trips }}
                                                trips)</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($booking->status === 'confirmed' || $booking->status === 'in_progress')
                        <div class="flex flex-col gap-3 lg:flex-shrink-0">
                            <a href="tel:{{ $booking->driver->phone }}"
                                class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                    </path>
                                </svg>
                                Call Driver
                            </a>
                            <a href="sms:{{ $booking->driver->phone }}"
                                class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-lg hover:shadow-xl hover:scale-105 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                    </path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Send SMS
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Pricing Breakdown -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Pricing Breakdown
                    </h3>
                </div>

                <div class="p-8">
                    <div class="space-y-6">
                        <div
                            class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border border-purple-200">
                            <span class="text-lg font-semibold text-gray-700">Base Price</span>
                            <span class="text-xl font-bold text-gray-900">KSh
                                {{ number_format($booking->price_per_unit, 2) }}</span>
                        </div>

                        @if($booking->passengers > 1 && $booking->transportationService->service_type === 'shared_ride')
                        <div
                            class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                            <span class="text-lg font-semibold text-gray-700">{{ $booking->passengers }}
                                passengers</span>
                            <span class="text-xl font-bold text-gray-900">KSh
                                {{ number_format($booking->price_per_unit * $booking->passengers, 2) }}</span>
                        </div>
                        @endif

                        @if($booking->surcharge_amount > 0)
                        <div
                            class="flex justify-between items-center p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl border border-orange-200">
                            <span class="text-lg font-semibold text-gray-700">Additional Charges</span>
                            <span class="text-xl font-bold text-gray-900">KSh
                                {{ number_format($booking->surcharge_amount, 2) }}</span>
                        </div>
                        @endif

                        <div class="border-t-2 border-gray-200 pt-6">
                            <div
                                class="flex justify-between items-center p-6 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl shadow-lg">
                                <span class="text-2xl font-bold text-white">Total Amount</span>
                                <span class="text-3xl font-black text-white">KSh
                                    {{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>

                        <div
                            class="flex justify-between items-center p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200">
                            <span class="text-lg font-semibold text-gray-700">Payment Status</span>
                            <span class="px-4 py-2 text-sm font-bold rounded-full shadow-lg uppercase tracking-wider
                                @if($booking->payment_status === 'paid') bg-gradient-to-r from-green-500 to-green-600 text-white
                                @elseif($booking->payment_status === 'pending') bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                                @elseif($booking->payment_status === 'failed') bg-gradient-to-r from-red-500 to-red-600 text-white
                                @else bg-gradient-to-r from-gray-500 to-gray-600 text-white
                                @endif">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Customer Information
                    </h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                            <label
                                class="block text-sm font-bold text-indigo-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Name
                            </label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                            <label
                                class="block text-sm font-bold text-blue-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                    </path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Email
                            </label>
                            <p class="text-lg font-semibold text-gray-900 break-all">{{ $booking->customer_email }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                            <label
                                class="block text-sm font-bold text-green-600 uppercase tracking-wider mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                    </path>
                                </svg>
                                Phone
                            </label>
                            <p class="text-lg font-semibold text-gray-900">{{ $booking->customer_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Cancel Booking Modal -->
    <div id="cancel-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" aria-hidden="true"></div>

            <div class="relative bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-pink-500/10"></div>
                <form method="POST" action="{{ route('booking.cancel', $booking) }}">
                    @csrf
                    <div class="relative z-10 p-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Cancel Booking</h3>
                                <p class="text-sm text-gray-600">This action cannot be undone</p>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-6">Are you sure you want to cancel this booking? Any payments made
                            will be refunded according to our cancellation policy.</p>

                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-bold text-gray-700 mb-3">Reason for
                                Cancellation (Optional)</label>
                            <textarea id="reason" name="reason" rows="3"
                                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Help us improve by telling us why you're cancelling..."></textarea>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 flex justify-end space-x-4">
                        <button type="button" onclick="closeCancelModal()"
                            class="bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 px-6 py-3 rounded-xl transition-all duration-200 font-semibold shadow-md hover:shadow-lg">
                            Keep Booking
                        </button>
                        <button type="submit"
                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                            Cancel Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function cancelBooking() {
        document.getElementById('cancel-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCancelModal() {
        document.getElementById('cancel-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('cancel-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCancelModal();
        }
    });

    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCancelModal();
        }
    });

    // Add smooth scrolling for better UX
    document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</x-app-layout>