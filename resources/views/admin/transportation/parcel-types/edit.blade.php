<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.transportation.parcel-types.index') }}" 
               class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Parcel Type') }}
                </h2>
                <p class="text-gray-600 mt-1">Update parcel type information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.transportation.parcel-types.update', $parcelType) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Parcel Type Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Parcel Type Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $parcelType->name) }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="e.g., Documents">
                        @error('name')
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
                                  placeholder="Describe this parcel type...">{{ old('description', $parcelType->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Optional - describe what items fit in this category</p>
                    </div>

                    <!-- Maximum Weight -->
                    <div>
                        <label for="max_weight_kg" class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Weight (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="max_weight_kg" 
                               name="max_weight_kg" 
                               value="{{ old('max_weight_kg', $parcelType->max_weight_kg) }}" 
                               required
                               step="0.1"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_weight_kg') border-red-500 @enderror"
                               placeholder="0.0">
                        @error('max_weight_kg')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Maximum weight this parcel type can handle</p>
                    </div>

                    <!-- Maximum Dimensions -->
                    <div>
                        <label for="max_dimensions" class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Dimensions
                        </label>
                        <input type="text" 
                               id="max_dimensions" 
                               name="max_dimensions" 
                               value="{{ old('max_dimensions', $parcelType->max_dimensions) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('max_dimensions') border-red-500 @enderror"
                               placeholder="e.g., 30x25x5 cm">
                        @error('max_dimensions')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Optional - format: Length x Width x Height (e.g., 30x25x5 cm)</p>
                    </div>

                    <!-- Base Rate -->
                    <div>
                        <label for="base_rate" class="block text-sm font-medium text-gray-700 mb-2">
                            Base Delivery Rate (KSh) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="base_rate" 
                               name="base_rate" 
                               value="{{ old('base_rate', $parcelType->base_rate) }}" 
                               required
                               step="0.01"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('base_rate') border-red-500 @enderror"
                               placeholder="0.00">
                        @error('base_rate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Base delivery rate used in pricing calculations</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $parcelType->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active Parcel Type</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active parcel types will be available for delivery pricing</p>
                    </div>

                    <!-- Information Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">
                                    Current Settings
                                </h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>This parcel type is currently configured for:</p>
                                    <ul class="list-disc list-inside mt-2 space-y-1">
                                        <li>Maximum weight: <strong>{{ $parcelType->max_weight_kg }} kg</strong></li>
                                        @if($parcelType->max_dimensions)
                                            <li>Maximum dimensions: <strong>{{ $parcelType->max_dimensions }}</strong></li>
                                        @endif
                                        <li>Base delivery rate: <strong>{{ $parcelType->formatted_base_rate }}</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                            Update Parcel Type
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
