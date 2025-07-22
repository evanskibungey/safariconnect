<x-admin-guest-layout :title="'Password Reset'" :subtitle="'Secure Password Recovery'">
    <!-- Info Section -->
    <div class="mb-6 text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
            <i class="fas fa-key text-blue-600 text-lg"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Admin Password Reset
        </h3>
        <p class="text-sm text-gray-600 leading-relaxed">
            Enter your admin email address and we'll send you a secure password reset link.
        </p>
    </div>

    <!-- Security Notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-shield-check text-blue-600"></i>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-semibold text-blue-900">
                    Secure Password Reset
                </h4>
                <p class="text-xs text-blue-700 mt-1">
                    Only the registered admin email can receive password reset links. All requests are logged for
                    security.
                </p>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-6" x-data="{ loading: false }">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Admin Email Address')" class="text-gray-700 font-medium" />
            <div class="relative mt-1">
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <x-text-input id="email"
                    class="input-with-icon w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                    type="email" name="email" :value="old('email')" required autofocus
                    placeholder="Enter your admin email address" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="admin-btn-primary w-full flex justify-center items-center" :disabled="loading"
                @click="loading = true">
                <span x-show="!loading" class="flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Password Reset Link
                </span>
                <span x-show="loading" class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Sending Reset Link...
                </span>
            </button>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-center pt-4 border-t border-gray-200">
            <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200"
                href="{{ route('admin.login') }}">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Admin Login
            </a>
        </div>
    </form>

    <!-- Security Information -->
    <div class="mt-6 bg-gray-50 rounded-lg p-4">
        <h4 class="text-xs font-medium text-gray-900 mb-2">
            <i class="fas fa-info-circle mr-1 text-blue-600"></i>
            Security Information:
        </h4>
        <ul class="text-xs text-gray-600 space-y-1">
            <li><i class="fas fa-check text-green-500 mr-2"></i>Password reset links expire after 60 minutes</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i>Links can only be used once for security</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i>All reset requests are logged and monitored</li>
            <li><i class="fas fa-check text-green-500 mr-2"></i>Only the registered admin email can receive links</li>
        </ul>
    </div>

    <!-- Alternative Contact -->
    <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-600"></i>
            </div>
            <div class="ml-3">
                <h4 class="text-xs font-medium text-yellow-800">
                    Can't Access Email?
                </h4>
                <p class="text-xs text-yellow-700 mt-1">
                    Contact system administrator or use: <code
                        class="bg-yellow-100 px-1 rounded font-mono">php artisan admin:manage reset</code>
                </p>
            </div>
        </div>
    </div>
</x-admin-guest-layout>