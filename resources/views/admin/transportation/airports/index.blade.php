<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Airports') }}
                </h2>
                <p class="text-gray-600 mt-1">Manage airports for transportation services</p>
            </div>
            <a href="{{ route('admin.transportation.airports.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Add Airport
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by name or code..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <select name="city_id" 
                                    id="city_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                        </div>
                        
                        <div class="flex items-end">
                            <a href="{{ route('admin.transportation.airports.index') }}" 
                               class="text-gray-600 hover:text-gray-800 px-4 py-2 transition duration-150 ease-in-out">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Airports Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($airports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Airport
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Code
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        City
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($airports as $airport)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $airport->name }}
                                                </div>
                                                @if($airport->description)
                                                    <div class="text-sm text-gray-500">
                                                        {{ Str::limit($airport->description, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900 font-mono">
                                                {{ $airport->code ?: '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">
                                                {{ $airport->city->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.transportation.airports.toggle', $airport) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition duration-150 ease-in-out
                                                               {{ $airport->is_active 
                                                                  ? 'bg-green-100 text-green-800 hover:bg-green-200' 
                                                                  : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                    {{ $airport->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.transportation.airports.show', $airport) }}" 
                                                   class="text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.transportation.airports.edit', $airport) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.transportation.airports.destroy', $airport) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this airport?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $airports->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <div class="text-gray-500 mb-4">
                            <i class="fas fa-plane text-4xl"></i>
                        </div>
                        <p class="text-gray-500 mb-4">No airports found.</p>
                        <a href="{{ route('admin.transportation.airports.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>Add First Airport
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.layouts.app>
