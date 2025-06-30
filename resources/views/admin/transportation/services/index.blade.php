<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Transportation Services') }}
                </h2>
                <p class="text-gray-600 mt-1">Manage your transportation service offerings</p>
            </div>
            <a href="{{ route('admin.transportation.services.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add New Service
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-6 border-b border-gray-200">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-car text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Total Services</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $services->total() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Active Services</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $services->where('is_active', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-tags text-purple-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Pricing Rules</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $services->sum(function($service) { return $service->servicePricing->count(); }) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-pause-circle text-orange-600 text-2xl mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Inactive Services</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $services->where('is_active', false)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Table -->
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing Rules</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($services as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r 
                                                @if($service->service_type === 'shared_ride') from-green-400 to-green-600 
                                                @elseif($service->service_type === 'solo_ride') from-blue-400 to-blue-600
                                                @elseif($service->service_type === 'airport_transfer') from-purple-400 to-purple-600
                                                @elseif($service->service_type === 'car_hire') from-orange-400 to-orange-600
                                                @else from-pink-400 to-pink-600 @endif
                                                flex items-center justify-center">
                                                <i class="fas fa-
                                                    @if($service->service_type === 'shared_ride') users
                                                    @elseif($service->service_type === 'solo_ride') car
                                                    @elseif($service->service_type === 'airport_transfer') plane
                                                    @elseif($service->service_type === 'car_hire') calendar
                                                    @else box @endif
                                                    text-white text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($service->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($service->service_type === 'shared_ride') bg-green-100 text-green-800
                                        @elseif($service->service_type === 'solo_ride') bg-blue-100 text-blue-800
                                        @elseif($service->service_type === 'airport_transfer') bg-purple-100 text-purple-800
                                        @elseif($service->service_type === 'car_hire') bg-orange-100 text-orange-800
                                        @else bg-pink-100 text-pink-800 @endif">
                                        {{ $service->service_type_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $service->pricing_model_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $service->servicePricing->count() }}</span>
                                        <span class="text-xs text-gray-500 ml-1">rules</span>
                                        @if($service->servicePricing->count() > 0)
                                            <a href="{{ route('admin.transportation.pricing.index', ['service_id' => $service->id]) }}" 
                                               class="ml-2 text-blue-600 hover:text-blue-900 text-xs">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.transportation.services.show', $service) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.transportation.services.edit', $service) }}" 
                                       class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.transportation.services.toggle', $service) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="{{ $service->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}"
                                                title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-{{ $service->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.transportation.services.destroy', $service) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this service? This will also delete all associated pricing rules.')">
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
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-car text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg font-medium text-gray-900 mb-2">No services found</p>
                                        <p class="text-gray-500 mb-4">Get started by creating your first transportation service</p>
                                        <a href="{{ route('admin.transportation.services.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                            <i class="fas fa-plus mr-2"></i>Create Service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($services->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $services->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layouts.app>
