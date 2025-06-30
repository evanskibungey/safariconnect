<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Service Pricing Management') }}
                </h2>
                <p class="text-gray-600 mt-1">Configure pricing rules for all transportation services</p>
            </div>
            <a href="{{ route('admin.transportation.pricing.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add Pricing Rule
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Filters -->
                <div class="border-b border-gray-200 p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                            <select name="service_id" id="service_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Services</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pickup_city_id" class="block text-sm font-medium text-gray-700 mb-1">Pickup City</label>
                            <select name="pickup_city_id" id="pickup_city_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('pickup_city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="dropoff_city_id" class="block text-sm font-medium text-gray-700 mb-1">Dropoff City</label>
                            <select name="dropoff_city_id" id="dropoff_city_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('dropoff_city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Pricing Table -->
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route/Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Additional Rates</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pricing as $price)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $price->transportationService->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $price->transportationService->service_type_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($price->pickupCity && $price->dropoffCity)
                                            {{ $price->pickupCity->name }} → {{ $price->dropoffCity->name }}
                                            @if($price->distance_km)
                                                <span class="text-gray-500">({{ $price->distance_km }}km)</span>
                                            @endif
                                        @elseif($price->pickupCity)
                                            From {{ $price->pickupCity->name }}
                                        @elseif($price->dropoffCity)
                                            To {{ $price->dropoffCity->name }}
                                        @else
                                            General Pricing
                                        @endif
                                    </div>
                                    @if($price->transfer_type)
                                        <div class="text-sm text-gray-500">{{ $price->transfer_type_name }}</div>
                                    @endif
                                    @if($price->parcel_type)
                                        <div class="text-sm text-gray-500">{{ $price->parcel_type_name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($price->vehicleType)
                                        <div class="text-sm font-medium text-gray-900">{{ $price->vehicleType->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $price->vehicleType->capacity }} seater</div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">KSh {{ number_format($price->base_price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs space-y-1">
                                        @if($price->price_per_km)
                                            <div>KSh {{ number_format($price->price_per_km, 2) }}/km</div>
                                        @endif
                                        @if($price->price_per_day)
                                            <div>KSh {{ number_format($price->price_per_day, 2) }}/day</div>
                                        @endif
                                        @if($price->airport_pickup_surcharge > 0)
                                            <div class="text-blue-600">+KSh {{ number_format($price->airport_pickup_surcharge, 2) }} pickup</div>
                                        @endif
                                        @if($price->airport_dropoff_surcharge > 0)
                                            <div class="text-blue-600">+KSh {{ number_format($price->airport_dropoff_surcharge, 2) }} dropoff</div>
                                        @endif
                                        @if($price->weekend_surcharge_percentage > 0)
                                            <div class="text-purple-600">+{{ $price->weekend_surcharge_percentage }}% weekend</div>
                                        @endif
                                        @if($price->night_surcharge_percentage > 0)
                                            <div class="text-orange-600">+{{ $price->night_surcharge_percentage }}% night</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $price->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $price->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.transportation.pricing.show', $price) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.transportation.pricing.edit', $price) }}" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.transportation.pricing.duplicate', $price) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900" title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transportation.pricing.toggle', $price) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="{{ $price->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}"
                                                title="{{ $price->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $price->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transportation.pricing.destroy', $price) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this pricing rule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No pricing rules found</p>
                                        <p class="text-gray-500 mb-4">Get started by creating your first pricing rule</p>
                                        <a href="{{ route('admin.transportation.pricing.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                            <i class="fas fa-plus mr-2"></i>Create Pricing Rule
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pricing->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pricing->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layouts.app>
