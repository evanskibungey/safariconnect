<nav x-data="{ open: false, transportationOpen: false }" class="bg-gradient-to-r from-gray-900 via-slate-800 to-gray-900 shadow-xl border-b border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-xl mr-3 shadow-lg group-hover:shadow-lg group-hover:shadow-orange-500/25 transition-all duration-200 p-1">
                            <img src="{{ asset('images/safarikonnect-logo.png') }}" alt="SafariConnect Logo" class="w-8 h-8 object-contain">
                        </div>
                        <div class="hidden md:block">
                            <h1 class="text-xl font-bold text-white group-hover:text-orange-300 transition-colors duration-200">SafariConnect</h1>
                            <p class="text-xs text-gray-400 -mt-1">Admin Dashboard</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden lg:flex lg:items-center lg:ml-8 lg:space-x-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                              {{ request()->routeIs('admin.dashboard') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Bookings -->
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                              {{ request()->routeIs('admin.bookings.*') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.bookings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Bookings
                        <span class="ml-2 px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">12</span>
                    </a>

                    <!-- Drivers -->
                    <a href="{{ route('admin.drivers.index') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                              {{ request()->routeIs('admin.drivers.*') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.drivers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Drivers
                    </a>

                    <!-- Transportation Services Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = ! open" 
                                class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                                       {{ request()->routeIs('admin.transportation.*') 
                                          ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                          : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.transportation.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Transportation
                            <svg class="w-3 h-3 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-2 w-64 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden">
                            
                            <!-- Core Services -->
                            <div class="p-1">
                                <div class="px-3 py-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Core Services</p>
                                </div>
                                <a href="{{ route('admin.transportation.services.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Services</p>
                                        <p class="text-xs text-gray-500">Manage transportation types</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.pricing.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Pricing</p>
                                        <p class="text-xs text-gray-500">Configure service rates</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="border-t border-gray-100"></div>
                            
                            <!-- Configuration -->
                            <div class="p-1">
                                <div class="px-3 py-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Configuration</p>
                                </div>
                                <a href="{{ route('admin.transportation.cities.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Cities</p>
                                        <p class="text-xs text-gray-500">Manage service locations</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.airports.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Airports</p>
                                        <p class="text-xs text-gray-500">Airport configurations</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-lg mr-3 group-hover:bg-indigo-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Vehicle Types</p>
                                        <p class="text-xs text-gray-500">Fleet management</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-lg mr-3 group-hover:bg-yellow-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Parcel Types</p>
                                        <p class="text-xs text-gray-500">Delivery categories</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <a href="{{ route('admin.settings.logo.index') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group
                              {{ request()->routeIs('admin.settings.*') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        Settings
                    </a>
                </div>
            </div>

            <!-- Right Side: Notifications & User Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button class="p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 relative">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = ! open" 
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-200 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="font-medium text-white group-hover:text-orange-300 transition-colors duration-200">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-56 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden">
                        <div class="p-1">
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Profile Settings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-gray-800 border-t border-gray-700">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <!-- Mobile Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') 
                         ? 'bg-orange-500 text-white' 
                         : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
                Dashboard
            </a>

            <!-- Mobile Bookings -->
            <a href="{{ route('admin.bookings.index') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-all duration-200
                      {{ request()->routeIs('admin.bookings.*') 
                         ? 'bg-orange-500 text-white' 
                         : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                Bookings
                <span class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">12</span>
            </a>

            <!-- Mobile Drivers -->
            <a href="{{ route('admin.drivers.index') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-all duration-200
                      {{ request()->routeIs('admin.drivers.*') 
                         ? 'bg-orange-500 text-white' 
                         : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                Drivers
            </a>

            <!-- Mobile Transportation Section -->
            <div class="border-t border-gray-700 pt-4 mt-4">
                <div class="px-3 py-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Transportation</p>
                </div>
                <a href="{{ route('admin.transportation.services.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Services
                </a>
                <a href="{{ route('admin.transportation.pricing.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    Pricing
                </a>
                <a href="{{ route('admin.transportation.cities.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Cities
                </a>
                <a href="{{ route('admin.transportation.airports.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"></path>
                    </svg>
                    Airports
                </a>
                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    Vehicle Types
                </a>
                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Parcel Types
                </a>
            </div>
        </div>

        <!-- Mobile User Menu -->
        <div class="border-t border-gray-700 pt-4 pb-3">
            <div class="flex items-center px-4">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mr-3">
                    <span class="text-white font-semibold">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <div class="text-base font-medium text-white">{{ Auth::guard('admin')->user()->name }}</div>
                    <div class="text-sm text-gray-400">{{ Auth::guard('admin')->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 px-4 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-3 py-2 rounded-lg text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
