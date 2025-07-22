<x-admin-guest-layout :title="'Admin Login'" :subtitle="'Secure Access Portal'">
    <!-- Security Status Alert -->
    <div class="security-info mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-shield-check text-blue-600 text-lg"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-semibold text-blue-900">
                    Enhanced Security Active
                </h3>
                <p class="text-xs text-blue-700 mt-1">
                    Single admin account policy enforced. All access attempts are monitored.
                </p>
            </div>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6" 
          x-data="{ 
              loading: false, 
              submitForm() { 
                  this.loading = true; 
                  this.$el.submit(); 
              } 
          }"
          @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
            <div class="relative mt-1">
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <x-text-input 
                    id="email" 
                    class="input-with-icon w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="admin@safarikonnect.com" 
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
            <div class="relative mt-1" x-data="{ showPassword: false }">
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <x-text-input 
                    id="password" 
                    class="input-with-icon w-full pr-12 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" 
                    ::type="showPassword ? 'text' : 'password'" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="Enter your secure password" 
                />
                <button 
                    type="button" 
                    @click="showPassword = !showPassword" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                >
                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Minimum 8 characters required (updated security policy)
            </p>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input 
                    id="remember" 
                    type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                    name="remember"
                >
                <label for="remember" class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-clock mr-1 text-gray-400"></i>
                    Remember me for 30 days
                </label>
            </div>
        </div>

        <!-- Security Features Info -->
        <div class="bg-gray-50 rounded-lg p-3">
            <h4 class="text-xs font-medium text-gray-900 mb-2">
                <i class="fas fa-shield-alt mr-1 text-green-600"></i>
                Security Features:
            </h4>
            <ul class="text-xs text-gray-600 space-y-1">
                <li><i class="fas fa-check text-green-500 mr-2"></i>Single admin account enforcement</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i>Rate limiting protection</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i>Session security monitoring</li>
                <li><i class="fas fa-check text-green-500 mr-2"></i>Failed attempt logging</li>
            </ul>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="admin-btn-primary w-full flex justify-center items-center transition-all duration-200" 
                :disabled="loading"
                :class="{ 'opacity-75 cursor-not-allowed': loading }"
            >
                <span x-show="!loading" class="flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Access Admin Portal
                </span>
                <span x-show="loading" class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Authenticating...
                </span>
            </button>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('admin.password.request'))
        <div class="text-center pt-4 border-t border-gray-200">
            <a 
                class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200" 
                href="{{ route('admin.password.request') }}"
            >
                <i class="fas fa-key mr-1"></i>
                Forgot your password?
            </a>
        </div>
        @endif

        <!-- Security Notice -->
        <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-xs font-medium text-yellow-800">
                        Security Notice
                    </h3>
                    <p class="text-xs text-yellow-700 mt-1">
                        Admin registration is permanently disabled. Only one admin account is permitted for security reasons.
                        All authentication attempts are logged and monitored.
                    </p>
                </div>
            </div>
        </div>
    </form>

    <!-- Reset loading state on page load if there are errors -->
    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reset any stuck loading states
            setTimeout(function() {
                if (window.Alpine) {
                    Alpine.store('loading', false);
                }
            }, 100);
        });
    </script>
    @endif

    <!-- Development Debug Info -->
    @if (app()->environment('local', 'development'))
    <div class="mt-8 p-4 bg-gray-100 border border-gray-200 rounded-lg">
        <h4 class="text-xs font-medium text-gray-800 mb-2">
            <i class="fas fa-bug mr-1"></i>
            Debug Info (Development Only):
        </h4>
        <div class="text-xs text-gray-600 space-y-1 font-mono">
            <p><strong>Environment:</strong> {{ app()->environment() }}</p>
            <p><strong>Guard:</strong> {{ Auth::guard('admin')->check() ? 'Authenticated' : 'Not authenticated' }}</p>
            <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
            <p><strong>Admin Exists:</strong> {{ App\Models\Admin::adminExists() ? 'Yes' : 'No' }}</p>
            @if(App\Models\Admin::adminExists())
                <p><strong>Admin Email:</strong> {{ App\Models\Admin::getSingleAdmin()->email ?? 'N/A' }}</p>
            @endif
            <p><strong>CSRF Token:</strong> {{ csrf_token() }}</p>
            <p><strong>Route:</strong> {{ route('admin.login') }}</p>
        </div>
    </div>
    @endif
</x-admin-guest-layout>