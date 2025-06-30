<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900">Admin Login</h2>
        <p class="text-gray-600 mt-2">Access the administrative panel</p>
    </div>

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Enter your admin email address" 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input 
                id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="Enter your password (minimum 4 characters)" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-sm text-gray-600">Minimum 4 characters required</p>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                id="remember" 
                type="checkbox" 
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                name="remember"
            >
            <label for="remember" class="ml-2 text-sm text-gray-600">
                {{ __('Remember me for 30 days') }}
            </label>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Login Failed
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>Please check your email and password and try again.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            @if (Route::has('admin.password.request'))
            <a 
                class="text-sm text-indigo-600 hover:text-indigo-900 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md" 
                href="{{ route('admin.password.request') }}"
            >
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ml-3 px-6 py-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Registration Link -->
        @if (Route::has('admin.register'))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Need admin access? 
                    <a 
                        class="font-medium text-indigo-600 hover:text-indigo-900 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md" 
                        href="{{ route('admin.register') }}"
                    >
                        Request an admin account
                    </a>
                </p>
            </div>
        </div>
        @endif
    </form>

    <!-- Debug Information (Remove in production) -->
    @if (app()->environment('local'))
    <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
        <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Info (Development Only):</h4>
        <div class="text-xs text-yellow-700 space-y-1">
            <p><strong>Admin Guard:</strong> {{ Auth::guard('admin')->check() ? 'Authenticated' : 'Not authenticated' }}</p>
            <p><strong>Session ID:</strong> {{ session()->getId() }}</p>
            <p><strong>CSRF Token:</strong> {{ csrf_token() }}</p>
        </div>
    </div>
    @endif
</x-guest-layout>