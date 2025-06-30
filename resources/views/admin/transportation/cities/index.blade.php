<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Cities Management') }}
                </h2>
                <p class="text-gray-600 mt-1">Manage pickup and drop-off locations</p>
            </div>
            <a href="{{ route('admin.transportation.cities.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add New City
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
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 border-b border-gray-200">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Total Cities</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $cities->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Active Cities</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $cities->where('is_active', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-pause-circle text-orange-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Inactive Cities</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $cities->where('is_active', false)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cities Table -->
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing Rules</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($cities as $city)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center">
                                                <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $city->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($city->state)
                                            {{ $city->state }}, 
                                        @endif
                                        {{ $city->country }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center">
                                            <span class="text-sm font-medium text-gray-900">{{ $city->pickupPricing->count() }}</span>
                                            <div class="text-xs text-gray-500">Pickup</div>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-sm font-medium text-gray-900">{{ $city->dropoffPricing->count() }}</span>
                                            <div class="text-xs text-gray-500">Dropoff</div>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-sm font-medium text-gray-900">{{ $city->pickupPricing->count() + $city->dropoffPricing->count() }}</span>
                                            <div class="text-xs text-gray-500">Total</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $city->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $city->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.transportation.cities.show', $city) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.transportation.cities.edit', $city) }}" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.transportation.cities.toggle', $city) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="{{ $city->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}"
                                                title="{{ $city->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $city->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transportation.cities.destroy', $city) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this city? This will also affect all associated pricing rules.')">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-map-marker-alt text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No cities found</p>
                                        <p class="text-gray-500 mb-4">Get started by adding your first city</p>
                                        <a href="{{ route('admin.transportation.cities.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                            <i class="fas fa-plus mr-2"></i>Add City
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($cities->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $cities->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layouts.app>
