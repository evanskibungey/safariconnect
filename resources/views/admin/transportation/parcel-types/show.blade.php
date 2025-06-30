<x-admin.layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                   class="text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $parcelType->name }}
                    </h2>
                    <p class="text-gray-600 mt-1">Parcel type details and specifications</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.transportation.parcel-types.edit', $parcelType) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Parcel Type
                </a>
                
                <form action="{{ route('admin.transportation.parcel-types.toggle', $parcelType) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $parcelType->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-150 ease-in-out">
                        <i class="fas fa-{{ $parcelType->is_active ? 'pause' : 'play' }} mr-2"></i>
                        {{ $parcelType->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Parcel Type Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Parcel Type Overview</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Parcel Icon & Info -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-lg bg-gradient-to-r from-pink-400 to-pink-600 flex items-center justify-center">
                                    <i class="fas fa-box text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Parcel Type</div>
                                <div class="text-lg font-semibold text-gray-900">{{ $parcelType->name }}</div>
                            </div>
                        </div>

                        <!-- Weight Limit -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Maximum Weight</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $parcelType->max_weight_kg }}</div>
                            <div class="text-sm text-gray-500">kg</div>
                        </div>

                        <!-- Base Rate -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Base Delivery Rate</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $parcelType->formatted_base_rate }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <div class="text-sm font-medium text-gray-500">Status</div>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $parcelType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $parcelType->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="p-6 border-b border-gray-200">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Specifications</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h5 class="font-medium text-gray-900 mb-2">Physical Limits</h5>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Maximum Weight:</span>
                                    <span class="font-semibold text-gray-900">{{ $parcelType->max_weight_kg }} kg</span>
                                </div>
                                @if($parcelType->max_dimensions)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Maximum Dimensions:</span>
                                    <span class="font-semibold text-gray-900">{{ $parcelType->max_dimensions }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h5 class="font-medium text-gray-900 mb-2">Pricing Information</h5>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Base Rate:</span>
                                    <span class="font-semibold text-gray-900">{{ $parcelType->formatted_base_rate }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Rate per kg:</span>
                                    <span class="font-semibold text-gray-900">
                                        KSh {{ number_format($parcelType->base_rate / $parcelType->max_weight_kg, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($parcelType->description)
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                    <p class="text-gray-700">{{ $parcelType->description }}</p>
                </div>
                @endif
            </div>

            <!-- Usage Examples -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Package Examples & Guidelines</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Suitable Items -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-medium text-green-900 mb-3 flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                Suitable Items
                            </h4>
                            @php
                                $suitableItems = [];
                                if($parcelType->max_weight_kg <= 0.5) {
                                    $suitableItems = ['Documents', 'Certificates', 'Letters', 'Photos', 'Small papers'];
                                } elseif($parcelType->max_weight_kg <= 5) {
                                    $suitableItems = ['Books', 'Small electronics', 'Jewelry', 'USB drives', 'Clothing items'];
                                } elseif($parcelType->max_weight_kg <= 15) {
                                    $suitableItems = ['Laptops', 'Tablets', 'Shoes', 'Multiple books', 'Small appliances'];
                                } else {
                                    $suitableItems = ['Desktop computers', 'Large electronics', 'Heavy documents', 'Bulk items', 'Household items'];
                                }
                            @endphp
                            <ul class="space-y-1">
                                @foreach($suitableItems as $item)
                                    <li class="text-sm text-green-700">
                                        <i class="fas fa-check text-green-500 mr-2"></i>{{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Restrictions -->
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h4 class="font-medium text-red-900 mb-3 flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                Restrictions
                            </h4>
                            <ul class="space-y-1 text-sm text-red-700">
                                <li><i class="fas fa-times text-red-500 mr-2"></i>Items exceeding {{ $parcelType->max_weight_kg }} kg</li>
                                @if($parcelType->max_dimensions)
                                    <li><i class="fas fa-times text-red-500 mr-2"></i>Items larger than {{ $parcelType->max_dimensions }}</li>
                                @endif
                                <li><i class="fas fa-times text-red-500 mr-2"></i>Fragile items without proper packaging</li>
                                <li><i class="fas fa-times text-red-500 mr-2"></i>Hazardous or prohibited materials</li>
                                <li><i class="fas fa-times text-red-500 mr-2"></i>Perishable goods (unless specified)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Cost Calculator -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Delivery Cost Calculator</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Base Rate -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Base Delivery</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Base Rate:</span>
                                    <span class="font-semibold">{{ $parcelType->formatted_base_rate }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Up to:</span>
                                    <span class="text-gray-600">{{ $parcelType->max_weight_kg }} kg</span>
                                </div>
                                <div class="border-t pt-2 flex justify-between font-bold">
                                    <span>Total:</span>
                                    <span>{{ $parcelType->formatted_base_rate }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Per KG Rate -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Rate per Kilogram</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Per kg rate:</span>
                                    <span class="font-semibold">KSh {{ number_format($parcelType->base_rate / $parcelType->max_weight_kg, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Example ({{ $parcelType->max_weight_kg / 2 }} kg):</span>
                                    <span class="text-gray-600">
                                        KSh {{ number_format(($parcelType->base_rate / $parcelType->max_weight_kg) * ($parcelType->max_weight_kg / 2), 2) }}
                                    </span>
                                </div>
                                <div class="border-t pt-2 text-sm text-gray-500">
                                    Based on proportional pricing
                                </div>
                            </div>
                        </div>

                        <!-- Cost Efficiency -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Cost Efficiency</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Max capacity:</span>
                                    <span class="font-semibold">{{ $parcelType->max_weight_kg }} kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Best value:</span>
                                    <span class="text-green-600">At max weight</span>
                                </div>
                                <div class="border-t pt-2 text-sm text-green-600">
                                    Most economical when using full capacity
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.transportation.pricing.create') }}?parcel_type={{ $parcelType->name }}" 
                           class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <i class="fas fa-plus mr-2"></i>
                            Create Pricing Rule
                        </a>
                        
                        <a href="{{ route('admin.transportation.parcel-types.edit', $parcelType) }}" 
                           class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Parcel Type
                        </a>
                        
                        <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                           class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <i class="fas fa-list mr-2"></i>
                            View All Types
                        </a>
                    </div>
                </div>
            </div>

            <!-- Parcel Type Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Parcel Type Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm font-medium text-gray-500">Created</div>
                            <div class="text-sm text-gray-900">{{ $parcelType->created_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Last Updated</div>
                            <div class="text-sm text-gray-900">{{ $parcelType->updated_at->format('F j, Y g:i A') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm font-medium text-gray-500">Parcel Type ID</div>
                            <div class="text-sm text-gray-900 font-mono">{{ $parcelType->id }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin.layouts.app>
