<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Bookings Link -->
                    <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                        <i class="fas fa-calendar-check mr-2"></i>
                        {{ __('Bookings') }}
                    </x-nav-link>

                    <!-- Drivers Link -->
                    <x-nav-link :href="route('admin.drivers.index')" :active="request()->routeIs('admin.drivers.*')">
                        <i class="fas fa-user-tie mr-2"></i>
                        {{ __('Drivers') }}
                    </x-nav-link>

                    <!-- Transportation Services Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = ! open" 
                                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                                {{ request()->routeIs('admin.transportation.*') ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300' }}">
                            <i class="fas fa-car mr-2"></i>
                            Transportation
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('admin.transportation.services.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-car mr-2 w-4"></i>
                                    Services
                                </a>
                                <a href="{{ route('admin.transportation.pricing.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-tags mr-2 w-4"></i>
                                    Pricing
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a href="{{ route('admin.transportation.cities.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                    Cities
                                </a>
                                <a href="{{ route('admin.transportation.airports.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-plane mr-2 w-4"></i>
                                    Airports
                                </a>
                                <a href="{{ route('admin.transportation.vehicle-types.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-truck mr-2 w-4"></i>
                                    Vehicle Types
                                </a>
                                <a href="{{ route('admin.transportation.parcel-types.index') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-box mr-2 w-4"></i>
                                    Parcel Types
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::guard('admin')->user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('admin.logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Bookings & Drivers Mobile Menu -->
            <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                <i class="fas fa-calendar-check mr-2"></i>{{ __('Bookings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.drivers.index')" :active="request()->routeIs('admin.drivers.*')">
                <i class="fas fa-user-tie mr-2"></i>{{ __('Drivers') }}
            </x-responsive-nav-link>

            <!-- Transportation Services Mobile Menu -->
            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 py-2">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Transportation
                    </div>
                </div>
                <x-responsive-nav-link :href="route('admin.transportation.services.index')" :active="request()->routeIs('admin.transportation.services.*')">
                    <i class="fas fa-car mr-2"></i>Services
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transportation.pricing.index')" :active="request()->routeIs('admin.transportation.pricing.*')">
                    <i class="fas fa-tags mr-2"></i>Pricing
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transportation.cities.index')" :active="request()->routeIs('admin.transportation.cities.*')">
                    <i class="fas fa-map-marker-alt mr-2"></i>Cities
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transportation.airports.index')" :active="request()->routeIs('admin.transportation.airports.*')">
                    <i class="fas fa-plane mr-2"></i>Airports
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transportation.vehicle-types.index')" :active="request()->routeIs('admin.transportation.vehicle-types.*')">
                    <i class="fas fa-truck mr-2"></i>Vehicle Types
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.transportation.parcel-types.index')" :active="request()->routeIs('admin.transportation.parcel-types.*')">
                    <i class="fas fa-box mr-2"></i>Parcel Types
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::guard('admin')->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('admin')->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('admin.logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Include Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
