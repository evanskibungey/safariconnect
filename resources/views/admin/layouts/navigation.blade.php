<nav x-data="{ 
    mobileMenuOpen: false, 
    transportationOpen: false,
    settingsOpen: false,
    userMenuOpen: false,
    notificationsOpen: false
}" 
class="bg-gradient-to-r from-gray-900 via-slate-800 to-gray-900 shadow-xl border-b border-gray-700">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-orange-500 text-white px-4 py-2 rounded-md">
        Skip to main content
    </a>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center group focus:outline-none focus:ring-2 focus:ring-orange-500 rounded-lg p-1"
                       aria-label="SafariConnect Admin Dashboard">
                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-xl mr-3 shadow-lg group-hover:shadow-lg group-hover:shadow-orange-500/25 transition-all duration-200 p-1">
                            @php
                                $logoPath = public_path('images/safarikonnect-logo.png');
                                $logoExists = file_exists($logoPath);
                            @endphp
                            @if($logoExists)
                                <img src="{{ asset('images/safarikonnect-logo.png') }}" 
                                     alt="SafariConnect Logo" 
                                     class="w-8 h-8 object-contain">
                            @else
                                <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="hidden md:block">
                            <h1 class="text-xl font-bold text-white group-hover:text-orange-300 transition-colors duration-200">SafariConnect</h1>
                            <p class="text-xs text-gray-400 -mt-1">Admin Dashboard</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex lg:items-center lg:ml-8 lg:space-x-1" role="navigation" aria-label="Main navigation">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500
                              {{ request()->routeIs('admin.dashboard') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}"
                       aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : 'false' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" 
                             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Bookings -->
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500
                              {{ request()->routeIs('admin.bookings.*') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}"
                       aria-current="{{ request()->routeIs('admin.bookings.*') ? 'page' : 'false' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.bookings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" 
                             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Bookings
                        @php
                            $pendingBookingsCount = \App\Models\Booking::where('status', 'pending')->count();
                        @endphp
                        @if($pendingBookingsCount > 0)
                            <span class="ml-2 px-2 py-0.5 text-xs bg-red-500 text-white rounded-full animate-pulse" aria-label="{{ $pendingBookingsCount }} pending bookings">
                                {{ $pendingBookingsCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Drivers -->
                    <a href="{{ route('admin.drivers.index') }}" 
                       class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500
                              {{ request()->routeIs('admin.drivers.*') 
                                 ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                 : 'text-gray-300 hover:text-white hover:bg-white/10' }}"
                       aria-current="{{ request()->routeIs('admin.drivers.*') ? 'page' : 'false' }}">
                        <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.drivers.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" 
                             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Drivers
                    </a>

                    <!-- Transportation Services Dropdown -->
                    <div class="relative">
                        <button @click="transportationOpen = !transportationOpen" 
                                @keydown.escape="transportationOpen = false"
                                @click.away="transportationOpen = false"
                                class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500
                                       {{ request()->routeIs('admin.transportation.*') 
                                          ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                          : 'text-gray-300 hover:text-white hover:bg-white/10' }}"
                                aria-expanded="transportationOpen"
                                aria-haspopup="true"
                                aria-controls="transportation-menu">
                            <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.transportation.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" 
                                 fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            Transportation
                            <svg class="w-3 h-3 ml-2 transition-transform duration-200" 
                                 :class="{ 'rotate-180': transportationOpen }" 
                                 fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="transportationOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-2 w-64 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden"
                             id="transportation-menu"
                             role="menu"
                             aria-orientation="vertical"
                             aria-labelledby="transportation-button">
                            
                            <!-- Core Services -->
                            <div class="p-1" role="none">
                                <div class="px-3 py-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Core Services</p>
                                </div>
                                <a href="{{ route('admin.transportation.services.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.services.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-lg mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Services</p>
                                        <p class="text-xs text-gray-500">Manage transportation types</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.pricing.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.pricing.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-lg mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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
                            <div class="p-1" role="none">
                                <div class="px-3 py-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Configuration</p>
                                </div>
                                <a href="{{ route('admin.transportation.cities.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.cities.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Cities</p>
                                        <p class="text-xs text-gray-500">Manage service locations</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.airports.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.airports.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-lg mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Airports</p>
                                        <p class="text-xs text-gray-500">Airport configurations</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.vehicle-types.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-indigo-100 rounded-lg mr-3 group-hover:bg-indigo-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Vehicle Types</p>
                                        <p class="text-xs text-gray-500">Fleet management</p>
                                    </div>
                                </a>
                                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.transportation.parcel-types.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-yellow-100 rounded-lg mr-3 group-hover:bg-yellow-200 transition-colors duration-200">
                                        <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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

                    <!-- Settings Dropdown -->
                    <div class="relative">
                        <button @click="settingsOpen = !settingsOpen" 
                                @keydown.escape="settingsOpen = false"
                                @click.away="settingsOpen = false"
                                class="flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500
                                       {{ request()->routeIs('admin.settings.*') 
                                          ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/25' 
                                          : 'text-gray-300 hover:text-white hover:bg-white/10' }}"
                                aria-expanded="settingsOpen"
                                aria-haspopup="true"
                                aria-controls="settings-menu">
                            <svg class="w-4 h-4 mr-2 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}" 
                                 fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            Settings
                            <svg class="w-3 h-3 ml-2 transition-transform duration-200" 
                                 :class="{ 'rotate-180': settingsOpen }" 
                                 fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="settingsOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-2 w-56 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden"
                             id="settings-menu"
                             role="menu"
                             aria-orientation="vertical"
                             aria-labelledby="settings-button">
                            <div class="p-1" role="none">
                                <a href="{{ route('admin.settings.logo.index') }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:text-orange-700 rounded-lg transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500 {{ request()->routeIs('admin.settings.logo.*') ? 'bg-orange-50 text-orange-700' : '' }}"
                                   role="menuitem"
                                   tabindex="-1">
                                    <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-orange-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Logo Management
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="#" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-400 cursor-not-allowed rounded-lg"
                                   role="menuitem"
                                   tabindex="-1"
                                   aria-disabled="true">
                                    <svg class="w-4 h-4 mr-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    General Settings
                                    <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">Coming Soon</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Right Side: Notifications & User Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button @click="notificationsOpen = !notificationsOpen"
                            @keydown.escape="notificationsOpen = false"
                            @click.away="notificationsOpen = false"
                            class="p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 relative focus:outline-none focus:ring-2 focus:ring-orange-500"
                            aria-label="View notifications"
                            aria-expanded="notificationsOpen"
                            aria-haspopup="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        @php
                            $unreadNotifications = 3; // This should come from your notification system
                        @endphp
                        @if($unreadNotifications > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-pulse">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-show="notificationsOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-80 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <!-- Notification items -->
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                                    <p class="text-sm font-medium text-gray-900">New booking received</p>
                                    <p class="text-xs text-gray-500 mt-1">John Doe booked a solo ride - 5 minutes ago</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                                    <p class="text-sm font-medium text-gray-900">Driver assignment needed</p>
                                    <p class="text-xs text-gray-500 mt-1">Airport transfer requires driver - 15 minutes ago</p>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150">
                                    <p class="text-sm font-medium text-gray-900">Payment received</p>
                                    <p class="text-xs text-gray-500 mt-1">KSh 5,000 for booking #SR20240112 - 1 hour ago</p>
                                </a>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-100">
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View all notifications</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button @click="userMenuOpen = !userMenuOpen" 
                            @keydown.escape="userMenuOpen = false"
                            @click.away="userMenuOpen = false"
                            class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-orange-500"
                            aria-expanded="userMenuOpen"
                            aria-haspopup="true"
                            aria-controls="user-menu">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="font-medium text-white group-hover:text-orange-300 transition-colors duration-200">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" 
                             :class="{ 'rotate-180': userMenuOpen }" 
                             fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <div x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-56 bg-white rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 border border-gray-200 overflow-hidden"
                         id="user-menu"
                         role="menu"
                         aria-orientation="vertical"
                         aria-labelledby="user-button">
                        <div class="p-1" role="none">
                            <div class="px-3 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::guard('admin')->user()->email }}</p>
                            </div>
                            <a href="#" 
                               class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500"
                               role="menuitem"
                               tabindex="-1">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Profile Settings
                            </a>
                            <a href="#" 
                               class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500"
                               role="menuitem"
                               tabindex="-1">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                </svg>
                                Account Settings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        role="menuitem"
                                        tabindex="-1">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        aria-expanded="mobileMenuOpen"
                        aria-controls="mobile-menu"
                        aria-label="Main menu">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" 
                              class="inline-flex" 
                              stroke-linecap="round" 
                              stroke-linejoin="round" 
                              stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" 
                              class="hidden" 
                              stroke-linecap="round" 
                              stroke-linejoin="round" 
                              stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="mobileMenuOpen = false"
         class="lg:hidden bg-gray-800 border-t border-gray-700"
         id="mobile-menu">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <!-- Mobile Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') 
                         ? 'bg-orange-500 text-white' 
                         : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                Bookings
                @if($pendingBookingsCount > 0)
                    <span class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">{{ $pendingBookingsCount }}</span>
                @endif
            </a>

            <!-- Mobile Drivers -->
            <a href="{{ route('admin.drivers.index') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-base font-medium transition-all duration-200
                      {{ request()->routeIs('admin.drivers.*') 
                         ? 'bg-orange-500 text-white' 
                         : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
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
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.services.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Services
                </a>
                <a href="{{ route('admin.transportation.pricing.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.pricing.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    Pricing
                </a>
                <a href="{{ route('admin.transportation.cities.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.cities.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    Cities
                </a>
                <a href="{{ route('admin.transportation.airports.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.airports.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                    Airports
                </a>
                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.vehicle-types.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                    </svg>
                    Vehicle Types
                </a>
                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.transportation.parcel-types.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Parcel Types
                </a>
            </div>

            <!-- Mobile Settings Section -->
            <div class="border-t border-gray-700 pt-4 mt-4">
                <div class="px-3 py-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</p>
                </div>
                <a href="{{ route('admin.settings.logo.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.settings.logo.*') ? 'bg-orange-500/20 text-orange-300' : 'text-gray-300 hover:text-white hover:bg-gray-700' }} transition-all duration-200">
                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                    Logo Management
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
                <a href="#" 
                   class="flex items-center px-3 py-2 rounded-lg text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    Profile
                </a>
                <a href="#" 
                   class="flex items-center px-3 py-2 rounded-lg text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>
                    Notifications
                    @if($unreadNotifications > 0)
                        <span class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">{{ $unreadNotifications }}</span>
                    @endif
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-3 py-2 rounded-lg text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Main content should have this ID for skip link -->
<main id="main-content">
    <!-- Page content goes here -->
</main>
