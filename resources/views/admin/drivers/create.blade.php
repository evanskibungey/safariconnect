@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Driver</h2>
            <a href="{{ route('admin.drivers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Please fix the following errors:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                    placeholder="+254 7XX XXX XXX"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="license_number" class="block text-sm font-medium text-gray-700">License Number <span class="text-red-500">*</span></label>
                                <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('license_number') border-red-500 @enderror">
                                @error('license_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="license_expiry" class="block text-sm font-medium text-gray-700">License Expiry Date <span class="text-red-500">*</span></label>
                                <input type="date" name="license_expiry" id="license_expiry" value="{{ old('license_expiry') }}" required
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('license_expiry') border-red-500 @enderror">
                                @error('license_expiry')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Vehicle Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700">Vehicle Type <span class="text-red-500">*</span></label>
                            <select name="vehicle_type_id" id="vehicle_type_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('vehicle_type_id') border-red-500 @enderror">
                                <option value="">Select Vehicle Type</option>
                                @foreach($vehicleTypes as $id => $name)
                                    <option value="{{ $id }}" {{ old('vehicle_type_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('vehicle_type_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_registration" class="block text-sm font-medium text-gray-700">Registration Number <span class="text-red-500">*</span></label>
                            <input type="text" name="vehicle_registration" id="vehicle_registration" value="{{ old('vehicle_registration') }}" required
                                placeholder="KAA 123A"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('vehicle_registration') border-red-500 @enderror">
                            @error('vehicle_registration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="vehicle_make" class="block text-sm font-medium text-gray-700">Vehicle Make</label>
                                <input type="text" name="vehicle_make" id="vehicle_make" value="{{ old('vehicle_make') }}"
                                    placeholder="Toyota, Nissan, etc."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="vehicle_model" class="block text-sm font-medium text-gray-700">Vehicle Model</label>
                                <input type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model') }}"
                                    placeholder="Corolla, Note, etc."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="vehicle_year" class="block text-sm font-medium text-gray-700">Year of Manufacture</label>
                                <input type="text" name="vehicle_year" id="vehicle_year" value="{{ old('vehicle_year') }}"
                                    placeholder="2020" maxlength="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="vehicle_color" class="block text-sm font-medium text-gray-700">Vehicle Color</label>
                                <input type="text" name="vehicle_color" id="vehicle_color" value="{{ old('vehicle_color') }}"
                                    placeholder="White, Silver, etc."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agreement & Status -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Agreement & Status</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="agreement_document" class="block text-sm font-medium text-gray-700">Agreement Document (Optional)</label>
                            <input type="file" name="agreement_document" id="agreement_document"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</p>
                            @error('agreement_document')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="agreement_date" class="block text-sm font-medium text-gray-700">Agreement Date</label>
                            <input type="date" name="agreement_date" id="agreement_date" value="{{ old('agreement_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Initial Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="offline" {{ old('status', 'offline') == 'offline' ? 'selected' : '' }}>Offline</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="busy" {{ old('status') == 'busy' ? 'selected' : '' }}>Busy</option>
                                </select>
                            </div>

                            <div>
                                <label for="is_active" class="block text-sm font-medium text-gray-700">Account Status</label>
                                <select name="is_active" id="is_active"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Any additional information about the driver...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.drivers.index') }}" 
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i>Create Driver
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validate year input
document.getElementById('vehicle_year').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
});

// Preview uploaded file name
document.getElementById('agreement_document').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        console.log('Selected file:', fileName);
    }
});
</script>
@endsection
