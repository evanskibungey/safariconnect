@extends('admin.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Driver Details</h2>
                <p class="text-gray-600">{{ $driver->name }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.drivers.edit', $driver) }}" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.drivers.index') }}" 
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
            </div>
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
                <!-- Personal Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">License Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->license_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">License Expiry</dt>
                            <dd class="mt-1 text-sm {{ $driver->license_expiry->isFuture() ? 'text-gray-900' : 'text-red-600' }}">
                                {{ $driver->license_expiry->format('F d, Y') }}
                                @if($driver->license_expiry->isPast())
                                    <span class="text-xs font-semibold">(EXPIRED)</span>
                                @elseif($driver->license_expiry->diffInDays(now()) <= 30)
                                    <span class="text-xs text-yellow-600">(Expires soon)</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $driver->status_badge_class }}">
                                    {{ ucfirst($driver->status) }}
                                </span>
                                @if(!$driver->is_active)
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Vehicle Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Vehicle Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicleType->name ?? 'Not Assigned' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_registration ?? 'N/A' }}</dd>
                        </div>
                        @if($driver->vehicle_details)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Vehicle Details</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_details }}</dd>
                            </div>
                        @else
                            @if($driver->vehicle_make)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Make</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_make }}</dd>
                                </div>
                            @endif
                            @if($driver->vehicle_model)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Model</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_model }}</dd>
                                </div>
                            @endif
                            @if($driver->vehicle_year)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Year</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_year }}</dd>
                                </div>
                            @endif
                            @if($driver->vehicle_color)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Color</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $driver->vehicle_color }}</dd>
                                </div>
                            @endif
                        @endif
                    </dl>
                </div>

                <!-- Agreement Information -->
                @if($driver->hasAgreement() || $driver->agreement_date)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Agreement Information</h3>
                        <dl class="space-y-3">
                            @if($driver->agreement_document)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Agreement Document</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('admin.drivers.download-document', $driver) }}" 
                                            class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-file-alt mr-2"></i>
                                            View Agreement Document
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($driver->agreement_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Agreement Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $driver->agreement_date->format('F d, Y') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                <!-- Recent Bookings -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Bookings</h3>
                    @if($driver->bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Route</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($driver->bookings as $booking)
                                        <tr>
                                            <td class="px-3 py-2 text-sm">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    {{ $booking->booking_reference }}
                                                </a>
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                {{ $booking->route_description }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-900">
                                                {{ $booking->travel_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-3 py-2 text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status_badge_class }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No bookings found for this driver.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistics</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Total Trips</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ number_format($driver->total_trips) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Driver Rating</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $driver->rating_display }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Bookings</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_bookings']) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Completed Bookings</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['completed_bookings']) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cancelled Bookings</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['cancelled_bookings']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Current Booking -->
                @if($stats['current_booking'])
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Booking</h3>
                        <div class="space-y-2">
                            <p class="text-sm">
                                <span class="font-medium">Reference:</span> 
                                <a href="{{ route('admin.bookings.show', $stats['current_booking']) }}" 
                                    class="text-indigo-600 hover:text-indigo-900">
                                    {{ $stats['current_booking']->booking_reference }}
                                </a>
                            </p>
                            <p class="text-sm">
                                <span class="font-medium">Route:</span> 
                                {{ $stats['current_booking']->route_description }}
                            </p>
                            <p class="text-sm">
                                <span class="font-medium">Status:</span> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $stats['current_booking']->status_badge_class }}">
                                    {{ ucfirst($stats['current_booking']->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <form action="{{ route('admin.drivers.update-status', $driver) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="available" {{ $driver->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="busy" {{ $driver->status == 'busy' ? 'selected' : '' }}>Busy</option>
                                <option value="offline" {{ $driver->status == 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update Status
                            </button>
                        </form>

                        <form action="{{ route('admin.drivers.toggle', $driver) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-{{ $driver->is_active ? 'red' : 'green' }}-600 text-white px-4 py-2 rounded-md hover:bg-{{ $driver->is_active ? 'red' : 'green' }}-700">
                                {{ $driver->is_active ? 'Deactivate Driver' : 'Activate Driver' }}
                            </button>
                        </form>

                        @if(!$driver->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->exists())
                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700"
                                    onclick="return confirm('Are you sure you want to delete this driver?')">
                                    Delete Driver
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Notes -->
                @if($driver->notes)
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Notes</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $driver->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
