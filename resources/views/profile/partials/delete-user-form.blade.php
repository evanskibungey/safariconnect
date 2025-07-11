<section class="space-y-6">
    <!-- Warning Message -->
    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-2xl p-6">
        <div class="flex items-start">
            <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-xl font-bold text-red-800 mb-3">⚠️ Permanent Account Deletion</h4>
                <div class="text-sm text-red-700 space-y-2">
                    <p class="font-semibold">Once your account is deleted, all of its resources and data will be permanently deleted, including:</p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        <li>All your booking history and travel records</li>
                        <li>Personal profile information and preferences</li>
                        <li>Payment history and transaction records</li>
                        <li>Any saved payment methods or addresses</li>
                        <li>Communication history with drivers and support</li>
                    </ul>
                    <p class="font-semibold mt-3">Before deleting your account, please download any data or information that you wish to retain.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Export Suggestion -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6">
        <div class="flex items-start">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-blue-800 mb-2">💾 Save Your Data First</h4>
                <p class="text-sm text-blue-700 mb-4">Consider downloading your booking history and personal data before proceeding.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('booking.history') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg hover:scale-105 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        View Booking History
                    </a>
                    <button onclick="window.print()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-semibold shadow-md hover:shadow-lg hover:scale-105 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
                        </svg>
                        Print Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Button -->
    <div class="flex justify-center">
        <button x-data="" 
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="group bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-4 rounded-xl transition-all duration-300 font-bold shadow-lg hover:shadow-xl hover:scale-105 flex items-center border-2 border-red-300 hover:border-red-400">
            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v12h10V5h-1a1 1 0 110-2h1a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
            </svg>
            <span class="text-lg">Delete My Account Permanently</span>
        </button>
    </div>

    <!-- Enhanced Deletion Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="relative">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6 rounded-t-2xl">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">⚠️ Confirm Account Deletion</h2>
                        <p class="text-red-100 text-sm mt-1">This action cannot be undone</p>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                @csrf
                @method('delete')

                <div class="space-y-6">
                    <!-- Warning Message -->
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4">
                        <p class="text-red-800 font-semibold text-center">
                            Are you absolutely sure you want to delete your account?
                        </p>
                        <p class="text-sm text-red-700 mt-2 text-center">
                            All of your data will be permanently deleted. This action cannot be undone.
                        </p>
                    </div>

                    <!-- Account Summary -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">What will be deleted:</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                {{ auth()->user()->bookings()->count() }} Bookings
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Profile Information
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Payment History
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                All Preferences
                            </div>
                        </div>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                            Enter your password to confirm deletion
                        </label>
                        <div class="relative">
                            <input id="password"
                                   name="password"
                                   type="password"
                                   class="w-full border-2 border-red-200 rounded-xl px-4 py-4 text-base focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-gradient-to-r from-red-50 to-pink-50 placeholder-gray-500"
                                   placeholder="Enter your current password"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('password', 'userDeletion')
                            <div class="mt-2 flex items-center text-red-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" 
                            x-on:click="$dispatch('close')"
                            class="bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 px-6 py-3 rounded-xl transition-all duration-200 font-semibold shadow-md hover:shadow-lg hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Cancel
                    </button>

                    <button type="submit" 
                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl transition-all duration-200 font-bold shadow-lg hover:shadow-xl hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Delete Account Forever
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
