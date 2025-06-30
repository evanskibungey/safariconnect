<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
               class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Vehicle Type') }}
                </h2>
                <p class="text-gray-600 mt-1">Update vehicle type information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.transportation.vehicle-types.update', $vehicleType) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Vehicle Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Vehicle Type Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $vehicleType->name) }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="e.g., 4-Seater Sedan">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Seating Capacity <span class="text-red-500">*</span>
                        </label>
                        <select id="capacity" 
                                name="capacity" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('capacity') border-red-500 @enderror">
                            <option value="">Select Capacity</option>
                            <option value="2" {{ old('capacity', $vehicleType->capacity) == '2' ? 'selected' : '' }}>2 Seater</option>
                            <option value="4" {{ old('capacity', $vehicleType->capacity) == '4' ? 'selected' : '' }}>4 Seater</option>
                            <option value="5" {{ old('capacity', $vehicleType->capacity) == '5' ? 'selected' : '' }}>5 Seater</option>
                            <option value="7" {{ old('capacity', $vehicleType->capacity) == '7' ? 'selected' : '' }}>7 Seater</option>
                            <option value="8" {{ old('capacity', $vehicleType->capacity) == '8' ? 'selected' : '' }}>8 Seater</option>
                            <option value="9" {{ old('capacity', $vehicleType->capacity) == '9' ? 'selected' : '' }}>9 Seater</option>
                            <option value="12" {{ old('capacity', $vehicleType->capacity) == '12' ? 'selected' : '' }}>12 Seater</option>
                            <option value="14" {{ old('capacity', $vehicleType->capacity) == '14' ? 'selected' : '' }}>14 Seater</option>
                            <option value="25" {{ old('capacity', $vehicleType->capacity) == '25' ? 'selected' : '' }}>25 Seater</option>
                            <option value="30" {{ old('capacity', $vehicleType->capacity) == '30' ? 'selected' : '' }}>30 Seater</option>
                            <option value="50" {{ old('capacity', $vehicleType->capacity) == '50' ? 'selected' : '' }}>50 Seater</option>
                        </select>
                        @error('capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Describe this vehicle type...">{{ old('description', $vehicleType->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Optional - provide details about features, comfort level, etc.</p>
                    </div>

                    <!-- Base Rate -->
                    <div>
                        <label for="base_rate" class="block text-sm font-medium text-gray-700 mb-2">
                            Base Rate (KSh) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="base_rate" 
                               name="base_rate" 
                               value="{{ old('base_rate', $vehicleType->base_rate) }}" 
                               required
                               step="0.01"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('base_rate') border-red-500 @enderror"
                               placeholder="0.00">
                        @error('base_rate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Base rate used in pricing calculations (per km or per day)</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $vehicleType->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active Vehicle Type</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active vehicle types will be available for pricing configuration</p>
                    </div>

                    <!-- Pricing Rules Notice -->
                    @if($vehicleType->servicePricing->count() > 0)
                    <div class="border-t pt-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Pricing Rules Notice
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>This vehicle type is used in {{ $vehicleType->servicePricing->count() }} pricing rule(s). Changing the capacity or base rate may affect existing pricing calculations.</p>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.transportation.vehicle-types.show', $vehicleType) }}" 
                                               class="text-yellow-800 underline hover:text-yellow-900">
                                                View all pricing rules →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                            Update Vehicle Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
