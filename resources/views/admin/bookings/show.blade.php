@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Booking Details</h2>
                <p class="text-gray-600">Reference: {{ $booking->booking_reference }}</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                Back to List
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Service</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->transportationService->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status_badge_class }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Travel Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travel_date->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Travel Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travel_time }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Route</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->route_description }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Passengers</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->passengers }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price per Passenger</dt>
                            <dd class="mt-1 text-sm text-gray-900">KSh {{ number_format($booking->price_per_unit, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">KSh {{ number_format($booking->total_price, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Customer Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->payment_status_badge_class }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                    
                    @if($booking->special_requirements)
                        <div class="mt-4">
                            <dt class="text-sm font-medium text-gray-500">Special Requirements</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->special_requirements }}</dd>
                        </div>
                    @endif
                </div>

                <!-- Driver Assignment -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Driver Assignment</h3>
                    
                    @if($booking->driver)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $booking->driver->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->driver->phone }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->driver->email }}</p>
                                    @if($booking->driver->vehicleType)
                                        <p class="text-sm text-gray-600">Vehicle: {{ $booking->driver->vehicleType->name }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600">License: {{ $booking->driver->license_number }}</p>
                                    <p class="text-sm text-gray-600">Rating: {{ $booking->driver->rating_display }}</p>
                                </div>
                                
                                @if(!in_array($booking->status, ['completed', 'cancelled']))
                                    <form action="{{ route('admin.bookings.remove-driver', $booking) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                            Remove Driver
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            @if($booking->driver_assigned_at)
                                <p class="text-xs text-gray-500 mt-2">
                                    Assigned on {{ $booking->driver_assigned_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>
                    @elseif($availableDrivers && $availableDrivers->count() > 0)
                        <form action="{{ route('admin.bookings.assign-driver', $booking) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Select Driver</label>
                                <select name="driver_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Choose a driver...</option>
                                    @foreach($availableDrivers as $driver)
                                        <option value="{{ $driver->id }}">
                                            {{ $driver->name }} - {{ $driver->phone }}
                                            @if($driver->vehicleType)
                                                ({{ $driver->vehicleType->name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Assign Driver
                            </button>
                        </form>
                    @else
                        <p class="text-gray-500">
                            @if(in_array($booking->status, ['completed', 'cancelled']))
                                Driver assignment not available for {{ $booking->status }} bookings.
                            @else
                                No available drivers at the moment.
                            @endif
                        </p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Update -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status</h3>
                    
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="in_progress" {{ $booking->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <div id="cancellation-reason" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Cancellation Reason</label>
                            <textarea name="cancellation_reason" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $booking->cancellation_reason }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Admin Notes</label>
                            <textarea name="admin_notes" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $booking->admin_notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Update Booking
                        </button>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        @if($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Confirm Booking
                                </button>
                            </form>
                        @endif
                        
                        @if(!in_array($booking->status, ['completed', 'cancelled']))
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                        
                        @if($booking->status === 'cancelled')
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                                    onclick="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                    Delete Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-gray-400 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Booking Created</p>
                                <p class="text-xs text-gray-500">{{ $booking->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($booking->confirmed_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-1.5"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Confirmed</p>
                                    <p class="text-xs text-gray-500">{{ $booking->confirmed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($booking->driver_assigned_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-purple-400 rounded-full mt-1.5"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Driver Assigned</p>
                                    <p class="text-xs text-gray-500">{{ $booking->driver_assigned_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($booking->cancelled_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-red-400 rounded-full mt-1.5"></div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Cancelled</p>
                                    <p class="text-xs text-gray-500">{{ $booking->cancelled_at->format('M d, Y g:i A') }}</p>
                                    @if($booking->cancellation_reason)
                                        <p class="text-xs text-gray-600 mt-1">{{ $booking->cancellation_reason }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    const cancellationDiv = document.getElementById('cancellation-reason');
    
    function toggleCancellationReason() {
        if (statusSelect.value === 'cancelled') {
            cancellationDiv.classList.remove('hidden');
        } else {
            cancellationDiv.classList.add('hidden');
        }
    }
    
    statusSelect.addEventListener('change', toggleCancellationReason);
    toggleCancellationReason();
});
</script>
@endsection
