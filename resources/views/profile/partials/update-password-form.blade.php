<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="space-y-6">
            <!-- Current Password -->
            <div>
                <label for="update_password_current_password" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    Current Password
                </label>
                <div class="relative">
                    <input id="update_password_current_password" 
                           name="current_password" 
                           type="password" 
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-base focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-gradient-to-r from-orange-50 to-red-50 placeholder-gray-500" 
                           autocomplete="current-password"
                           placeholder="Enter your current password">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <button type="button" onclick="togglePasswordVisibility('update_password_current_password')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="mt-2 flex items-center text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="update_password_password" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    New Password
                </label>
                <div class="relative">
                    <input id="update_password_password" 
                           name="password" 
                           type="password" 
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-base focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gradient-to-r from-green-50 to-emerald-50 placeholder-gray-500" 
                           autocomplete="new-password"
                           placeholder="Enter your new password">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <button type="button" onclick="togglePasswordVisibility('update_password_password')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-2 bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Password Requirements:
                    </p>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li>• At least 8 characters long</li>
                        <li>• Contains uppercase and lowercase letters</li>
                        <li>• Contains at least one number</li>
                        <li>• Contains at least one special character</li>
                    </ul>
                </div>
                @error('password', 'updatePassword')
                    <div class="mt-2 flex items-center text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Confirm New Password
                </label>
                <div class="relative">
                    <input id="update_password_password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-base focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gradient-to-r from-purple-50 to-violet-50 placeholder-gray-500" 
                           autocomplete="new-password"
                           placeholder="Confirm your new password">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <button type="button" onclick="togglePasswordVisibility('update_password_password_confirmation')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <div class="mt-2 flex items-center text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                @enderror
            </div>
        </div>

        <!-- Security Tips -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-indigo-800 mb-2">Security Best Practices</h4>
                    <ul class="text-sm text-indigo-700 space-y-1">
                        <li>• Use a unique password that you don't use elsewhere</li>
                        <li>• Consider using a password manager</li>
                        <li>• Never share your password with anyone</li>
                        <li>• Change your password regularly</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-4">
                <button type="submit" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-90"
                         x-init="setTimeout(() => show = false, 3000)"
                         class="flex items-center bg-gradient-to-r from-green-100 to-emerald-100 border border-green-200 text-green-800 px-6 py-3 rounded-xl shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Password updated successfully!</span>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Optionally, you can change the icon here
            const button = input.nextElementSibling.querySelector('button');
            const svg = button.querySelector('svg');
            
            if (type === 'text') {
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3.036 3.036m6.842 6.842L21.964 21.964"></path>
                `;
            } else {
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</section>
