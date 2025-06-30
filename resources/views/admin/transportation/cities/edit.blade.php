<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.transportation.cities.index') }}" 
               class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit City') }}
                </h2>
                <p class="text-gray-600 mt-1">Update city information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.transportation.cities.update', $city) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- City Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            City Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $city->name) }}" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="e.g., Nairobi">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State/Province -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                            State/Province/County
                        </label>
                        <input type="text" 
                               id="state" 
                               name="state" 
                               value="{{ old('state', $city->state) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('state') border-red-500 @enderror"
                               placeholder="e.g., Nairobi County">
                        @error('state')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Optional - helps distinguish cities with same names</p>
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <select id="country" 
                                name="country" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror">
                            <option value="">Select Country</option>
                            <option value="Kenya" {{ old('country', $city->country) === 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="Uganda" {{ old('country', $city->country) === 'Uganda' ? 'selected' : '' }}>Uganda</option>
                            <option value="Tanzania" {{ old('country', $city->country) === 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                            <option value="Rwanda" {{ old('country', $city->country) === 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                            <option value="Burundi" {{ old('country', $city->country) === 'Burundi' ? 'selected' : '' }}>Burundi</option>
                            <option value="South Sudan" {{ old('country', $city->country) === 'South Sudan' ? 'selected' : '' }}>South Sudan</option>
                            <option value="Ethiopia" {{ old('country', $city->country) === 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                            <option value="Somalia" {{ old('country', $city->country) === 'Somalia' ? 'selected' : '' }}>Somalia</option>
                            <option value="Other" {{ old('country', $city->country) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('country')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $city->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active City</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Only active cities will be available for creating pricing rules</p>
                    </div>

                    <!-- Pricing Rules Notice -->
                    @if($city->pickupPricing->count() > 0 || $city->dropoffPricing->count() > 0)
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
                                        <p>This city is used in {{ $city->pickupPricing->count() + $city->dropoffPricing->count() }} pricing rule(s):</p>
                                        <ul class="list-disc list-inside mt-2 space-y-1">
                                            @if($city->pickupPricing->count() > 0)
                                                <li>{{ $city->pickupPricing->count() }} pickup location(s)</li>
                                            @endif
                                            @if($city->dropoffPricing->count() > 0)
                                                <li>{{ $city->dropoffPricing->count() }} dropoff location(s)</li>
                                            @endif
                                        </ul>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.transportation.cities.show', $city) }}" 
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
                        <a href="{{ route('admin.transportation.cities.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                            Update City
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.layouts.app>
