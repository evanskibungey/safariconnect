<!-- Login Modal -->
<div id="login-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity duration-300" aria-hidden="true">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-slate-900/80 to-gray-900/80 backdrop-blur-sm"></div>
        </div>

        <!-- Modal panel -->
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border-2 border-white/20 backdrop-blur-sm"
            style="box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1)">

            <!-- Modal Header with Logo -->
            <div class="bg-gradient-to-r from-orange-600 via-amber-600 to-orange-700 px-6 py-5 sticky top-0 z-10 shadow-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- SafariConnect Logo - Optimized for 400x150px (2.67:1 ratio) -->
                        <div class="h-6 w-16 sm:h-8 sm:w-20">
                            <!-- Your SafariConnect Logo -->
                            <img src="{{ asset('images/safarikonnect-logo.png') }}" 
                                 alt="SafariConnect Logo" 
                                 class="w-full h-full object-contain"
                                 style="filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white drop-shadow-sm">Welcome Back</h3>
                            <p class="text-sm text-white/80">Sign in to your SafariConnect account</p>
                        </div>
                    </div>
                    <button id="close-login-modal"
                        class="p-2 text-white hover:text-gray-200 hover:bg-white/20 rounded-xl transition-all duration-200 border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <!-- Login Form -->
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email or Phone -->
                    <div class="mb-4">
                        <label for="login" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email or Phone Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="login" type="text" name="login" required autofocus 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Enter your email or phone number">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">You can login with either your email address or phone number</p>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                placeholder="Enter your password">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" 
                                class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                                class="text-sm text-orange-600 hover:text-orange-800 font-medium transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Error Messages -->
                    <div id="login-errors" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Login Failed</h3>
                                <div id="login-error-message" class="mt-1 text-sm text-red-700"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="login-submit-btn"
                        class="w-full bg-gradient-to-r from-orange-600 via-amber-600 to-red-500 text-white py-3 px-4 rounded-lg hover:from-red-500 hover:via-amber-600 hover:to-orange-600 transition-all duration-200 transform hover:scale-105 shadow-md font-semibold">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span id="login-btn-text">Sign In</span>
                        </span>
                    </button>
                </form>

                <!-- Registration Link -->
                <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" 
                            class="text-orange-600 hover:text-orange-800 font-semibold transition-colors">
                            Create Account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginModal = document.getElementById('login-modal');
    const loginForm = document.getElementById('login-form');
    const closeModalBtn = document.getElementById('close-login-modal');
    const submitBtn = document.getElementById('login-submit-btn');
    const btnText = document.getElementById('login-btn-text');
    const errorDiv = document.getElementById('login-errors');
    const errorMessage = document.getElementById('login-error-message');

    // Show modal function
    window.showLoginModal = function() {
        loginModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Focus on the login input
        setTimeout(() => {
            document.getElementById('login').focus();
        }, 100);
    };

    // Hide modal function
    function hideLoginModal() {
        loginModal.classList.add('hidden');
        document.body.style.overflow = '';
        // Reset form
        loginForm.reset();
        errorDiv.classList.add('hidden');
    }

    // Close modal event listeners
    closeModalBtn.addEventListener('click', hideLoginModal);
    
    // Close on background click
    loginModal.addEventListener('click', function(e) {
        if (e.target === loginModal) {
            hideLoginModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
            hideLoginModal();
        }
    });

    // Handle form submission
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.textContent = 'Signing In...';
        errorDiv.classList.add('hidden');

        // Prepare form data
        const formData = new FormData(loginForm);

        // Submit via fetch
        fetch(loginForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => {
            if (response.redirected) {
                // Successful login - redirect to intended page
                window.location.href = response.url;
                return;
            }
            return response.text();
        })
        .then(text => {
            if (text) {
                // Parse response for errors
                const parser = new DOMParser();
                const doc = parser.parseFromString(text, 'text/html');
                const errors = doc.querySelectorAll('.text-red-600, .text-sm.text-red-600');
                
                if (errors.length > 0) {
                    errorMessage.textContent = errors[0].textContent || 'Invalid login credentials. Please try again.';
                    errorDiv.classList.remove('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Login error:', error);
            errorMessage.textContent = 'An error occurred. Please try again.';
            errorDiv.classList.remove('hidden');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            btnText.textContent = 'Sign In';
        });
    });
});
</script>
