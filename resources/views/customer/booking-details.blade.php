<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Booking Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Reference: {{ $booking->booking_reference }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('booking.history') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Back to History
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Booking Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Booking Status</h3>
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $booking->status_badge_class }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <!-- Status Timeline -->
                    <div class="flex items-center space-x-4 text-sm">
                        <div class="flex items-center {{ $booking->status === 'pending' ? 'text-yellow-600' : 'text-green-600' }}">
                            <div class="w-3 h-3 rounded-full {{ $booking->status === 'pending' ? 'bg-yellow-400' : 'bg-green-400' }} mr-2"></div>
                            <span>Booking Submitted</span>
                        </div>
                        <div class="w-8 border-t border-gray-300"></div>
                        <div class="flex items-center {{ in_array($booking->status, ['confirmed', 'in_progress', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-3 h-3 rounded-full {{ in_array($booking->status, ['confirmed', 'in_progress', 'completed']) ? 'bg-green-400' : 'bg-gray-300' }} mr-2"></div>
                            <span>Confirmed</span>
                        </div>
                        <div class="w-8 border-t border-gray-300"></div>
                        <div class="flex items-center {{ in_array($booking->status, ['in_progress', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-3 h-3 rounded-full {{ in_array($booking->status, ['in_progress', 'completed']) ? 'bg-green-400' : 'bg-gray-300' }} mr-2"></div>
                            <span>In Progress</span>
                        </div>
                        <div class="w-8 border-t border-gray-300"></div>
                        <div class="flex items-center {{ $booking->status === 'completed' ? 'text-green-600' : 'text-gray-400' }}">
                            <div class="w-3 h-3 rounded-full {{ $booking->status === 'completed' ? 'bg-green-400' : 'bg-gray-300' }} mr-2"></div>
                            <span>Completed</span>
                        </div>
                    </div>

                    <!-- Cancellation Status -->
                    @if($booking->status === 'cancelled')
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Booking Cancelled</p>
                                    @if($booking->cancelled_at)
                                        <p class="text-xs text-red-600">Cancelled on {{ $booking->cancelled_at->format('M d, Y \a\t g:i A') }}</p>
                                    @endif
                                    @if($booking->cancellation_reason)
                                        <p class="text-xs text-red-600 mt-1">Reason: {{ $booking->cancellation_reason }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 flex space-x-3">
                        @if($booking->status === 'pending')
                            <button onclick="cancelBooking()" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Cancel Booking
                            </button>
                        @endif
                        @if($booking->status === 'completed')
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Rate Experience
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Service Type</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->transportationService->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Booking Reference</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono">{{ $booking->booking_reference }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Route</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->route_description }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Travel Date & Time</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $booking->travel_date->format('l, F j, Y') }} at {{ $booking->travel_time }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Passengers</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->passengers }} passenger(s)</p>
                        </div>
                        
                        @if($booking->vehicleType)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Vehicle Type</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $booking->vehicleType->name }}</p>
                            </div>
                        @endif
                        
                        @if($booking->transfer_type)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transfer Type</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($booking->transfer_type) }}</p>
                            </div>
                        @endif
                        
                        @if($booking->flight_number)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Flight Number</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $booking->flight_number }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Booking Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($booking->special_requirements)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500">Special Requirements</label>
                            <div class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">
                                @if($booking->transportationService->service_type === 'parcel_delivery' && $booking->parcel_info)
                                    @php $parcelInfo = $booking->parcel_info; @endphp
                                    <div class="space-y-2">
                                        @if(isset($parcelInfo->description))
                                            <p><strong>Description:</strong> {{ $parcelInfo->description }}</p>
                                        @endif
                                        @if(isset($parcelInfo->weight))
                                            <p><strong>Weight:</strong> {{ $parcelInfo->weight }}</p>
                                        @endif
                                        @if(isset($parcelInfo->type))
                                            <p><strong>Type:</strong> {{ $parcelInfo->type }}</p>
                                        @endif
                                        @if(isset($parcelInfo->sender_address))
                                            <p><strong>Sender Address:</strong> {{ $parcelInfo->sender_address }}</p>
                                        @endif
                                        @if(isset($parcelInfo->recipient_name))
                                            <p><strong>Recipient:</strong> {{ $parcelInfo->recipient_name }}</p>
                                        @endif
                                        @if(isset($parcelInfo->recipient_phone))
                                            <p><strong>Recipient Phone:</strong> {{ $parcelInfo->recipient_phone }}</p>
                                        @endif
                                        @if(isset($parcelInfo->recipient_address))
                                            <p><strong>Recipient Address:</strong> {{ $parcelInfo->recipient_address }}</p>
                                        @endif
                                        @if(isset($parcelInfo->urgent))
                                            <p class="text-red-600 font-medium">🚨 URGENT DELIVERY</p>
                                        @endif
                                        @if(isset($parcelInfo->signature_required))
                                            <p class="text-blue-600 font-medium">✍️ SIGNATURE REQUIRED</p>
                                        @endif
                                        @if(isset($parcelInfo->insurance))
                                            <p class="text-green-600 font-medium">🛡️ INSURANCE COVERAGE</p>
                                        @endif
                                    </div>
                                @else
                                    {!! nl2br(e($booking->special_requirements)) !!}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Driver Information -->
            @if($booking->driver)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Driver Information</h3>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900">{{ $booking->driver->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $booking->driver->phone }}</p>
                                @if($booking->driver->vehicle_details)
                                    <p class="text-sm text-gray-600">Vehicle: {{ $booking->driver->vehicle_details }}</p>
                                @endif
                                @if($booking->driver->vehicle_registration)
                                    <p class="text-sm text-gray-600">Plate: {{ $booking->driver->vehicle_registration }}</p>
                                @endif
                                @if($booking->driver->rating && $booking->driver->total_trips > 0)
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-600 mr-1">Rating:</span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $booking->driver->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                            <span class="ml-1 text-sm text-gray-600">({{ $booking->driver->total_trips }} trips)</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($booking->status === 'confirmed' || $booking->status === 'in_progress')
                                <div class="flex flex-col space-y-2">
                                    <a href="tel:{{ $booking->driver->phone }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                        Call Driver
                                    </a>
                                    <a href="sms:{{ $booking->driver->phone }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing Breakdown</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Base Price</span>
                            <span class="text-sm font-medium text-gray-900">KSh {{ number_format($booking->price_per_unit, 2) }}</span>
                        </div>
                        
                        @if($booking->passengers > 1 && $booking->transportationService->service_type === 'shared_ride')
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $booking->passengers }} passengers</span>
                                <span class="text-sm font-medium text-gray-900">KSh {{ number_format($booking->price_per_unit * $booking->passengers, 2) }}</span>
                            </div>
                        @endif
                        
                        @if($booking->surcharge_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Additional Charges</span>
                                <span class="text-sm font-medium text-gray-900">KSh {{ number_format($booking->surcharge_amount, 2) }}</span>
                            </div>
                        @endif
                        
                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total Amount</span>
                            <span class="text-lg font-bold text-green-600">KSh {{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Payment Status</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $booking->payment_status_badge_class }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->customer_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->customer_email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Phone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $booking->customer_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div id="cancel-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/75"></div>
            </div>
            
            <div class="relative bg-white rounded-lg max-w-md w-full">
                <form method="POST" action="{{ route('booking.cancel', $booking) }}">
                    @csrf
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Booking</h3>
                        <p class="text-sm text-gray-600 mb-4">Are you sure you want to cancel this booking? This action cannot be undone.</p>
                        
                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                            <textarea id="reason" name="reason" rows="3" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Tell us why you're cancelling..."></textarea>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                        <button type="button" onclick="closeCancelModal()" 
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors text-sm">
                            Keep Booking
                        </button>
                        <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
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
        }

        function closeCancelModal() {
            document.getElementById('cancel-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('cancel-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-app-layout>
