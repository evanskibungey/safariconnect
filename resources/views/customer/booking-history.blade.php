<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Booking History
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    View and manage all your bookings
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ url('/') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    New Booking
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters and Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('booking.history') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                        <!-- Search by Reference -->
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Reference</label>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Enter booking reference..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        
                        <!-- Filter by Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" 
                                    name="status"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-500 focus:border-orange-500">
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
                            <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                            <select id="service" 
                                    name="service"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-500 focus:border-orange-500">
                                <option value="">All Services</option>
                                @foreach($serviceTypes as $value => $label)
                                    <option value="{{ $value }}" {{ request('service') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Filter Buttons -->
                        <div class="flex space-x-2">
                            <button type="submit" 
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Filter
                            </button>
                            <a href="{{ route('booking.history') }}" 
                               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors text-sm">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bookings Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $bookings->total() }}</div>
                        <div class="text-sm text-gray-600">Total Bookings</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">
                            {{ auth()->user()->bookings()->where('status', 'completed')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Completed</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ auth()->user()->bookings()->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Pending</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">
                            KSh {{ number_format(auth()->user()->bookings()->sum('total_price'), 0) }}
                        </div>
                        <div class="text-sm text-gray-600">Total Spent</div>
                    </div>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($bookings->count() > 0)
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $booking->booking_reference }}</div>
                                                <div class="text-xs text-gray-500">{{ $booking->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $booking->transportationService->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $booking->passengers }} passenger(s)</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $booking->route_description }}</div>
                                                @if($booking->driver)
                                                    <div class="text-xs text-blue-600">Driver: {{ $booking->driver->name }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $booking->travel_date->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $booking->travel_time }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status_badge_class }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                                @if($booking->payment_status === 'paid')
                                                    <div class="text-xs text-green-600 mt-1">✓ Paid</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                KSh {{ number_format($booking->total_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('booking.details', $booking) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                @if($booking->driver && ($booking->status === 'confirmed' || $booking->status === 'in_progress'))
                                                    <a href="tel:{{ $booking->driver->phone }}" 
                                                       class="text-green-600 hover:text-green-900">
                                                        Call
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($bookings as $booking)
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 
                                    @if($booking->status === 'pending') border-yellow-400
                                    @elseif($booking->status === 'confirmed') border-blue-400
                                    @elseif($booking->status === 'in_progress') border-green-400
                                    @elseif($booking->status === 'completed') border-green-600
                                    @elseif($booking->status === 'cancelled') border-red-400
                                    @endif">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">{{ $booking->booking_reference }}</h4>
                                            <p class="text-xs text-gray-500">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $booking->status_badge_class }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-1 mb-3">
                                        <p class="text-sm text-gray-700">
                                            <strong>{{ $booking->transportationService->name }}</strong>
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $booking->route_description }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $booking->travel_date->format('M d, Y') }} at {{ $booking->travel_time }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900">
                                            KSh {{ number_format($booking->total_price, 2) }}
                                        </p>
                                        @if($booking->driver)
                                            <p class="text-sm text-blue-600">
                                                Driver: {{ $booking->driver->name }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('booking.details', $booking) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-2 rounded transition-colors">
                                            View Details
                                        </a>
                                        @if($booking->driver && ($booking->status === 'confirmed' || $booking->status === 'in_progress'))
                                            <a href="tel:{{ $booking->driver->phone }}" 
                                               class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-2 rounded transition-colors">
                                                Call Driver
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $bookings->withQueryString()->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No bookings found</h3>
                            @if(request()->hasAny(['search', 'status', 'service']))
                                <p class="text-gray-600 mb-4">No bookings match your current filters.</p>
                                <a href="{{ route('booking.history') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                    Clear Filters
                                </a>
                            @else
                                <p class="text-gray-600 mb-4">You haven't made any bookings yet.</p>
                                <a href="{{ url('/') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
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
