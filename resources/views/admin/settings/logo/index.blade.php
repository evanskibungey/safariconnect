@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Logo Management</h1>
                    <p class="text-gray-600 mt-1">Upload and manage your SafariConnect logos</p>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Main Logo Management -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-orange-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                        </svg>
                        Main Logo
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Used in navigation bars and headers</p>
                </div>
                
                <div class="p-6">
                    <!-- Current Logo Display -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Current Logo</label>
                        <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-200">
                            @if($currentLogo)
                                <div class="text-center">
                                    <img src="{{ asset($currentLogo) }}" alt="Current Logo" class="max-w-full max-h-24 mx-auto object-contain mb-3">
                                    <p class="text-sm text-gray-600">{{ basename($currentLogo) }}</p>
                                    <form action="{{ route('admin.settings.logo.delete') }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete the current logo?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="logo_type" value="main">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-medium hover:bg-red-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v4a1 1 0 11-2 0V7zm4 0a1 1 0 112 0v4a1 1 0 11-2 0V7z" clip-rule="evenodd"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p>No logo uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('admin.settings.logo.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="logo_type" value="main">
                        
                        <div>
                            <label for="main_logo" class="block text-sm font-medium text-gray-700 mb-2">Upload New Logo</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="main_logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG (MAX. 2MB)</p>
                                    </div>
                                    <input id="main_logo" name="logo" type="file" class="hidden" accept="image/*" required>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-orange-700 hover:to-red-700 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload Main Logo
                        </button>
                    </form>
                </div>
            </div>

            <!-- Favicon Management -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Favicon
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Browser tab icon (16x16 or 32x32 recommended)</p>
                </div>
                
                <div class="p-6">
                    <!-- Upload Form -->
                    <form action="{{ route('admin.settings.logo.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="logo_type" value="favicon">
                        
                        <div>
                            <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Upload Favicon</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="favicon" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                                        <p class="text-xs text-gray-500">ICO, PNG (16x16 or 32x32)</p>
                                    </div>
                                    <input id="favicon" name="logo" type="file" class="hidden" accept="image/*,.ico" required>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload Favicon
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Guidelines -->
        <div class="mt-8 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                Logo Guidelines
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Main Logo Recommendations:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Optimal size: 400x150px (2.67:1 ratio)</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Format: PNG with transparent background</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Maximum file size: 2MB</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>High resolution for clarity on all devices</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-2">Favicon Recommendations:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Size: 16x16px or 32x32px</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Format: ICO or PNG</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Simple design that's recognizable when small</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Consistent with main logo branding</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview uploaded images
document.getElementById('main_logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if needed
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('favicon').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if needed
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
