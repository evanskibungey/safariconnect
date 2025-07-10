<!-- Header -->
<header class="fixed top-0 left-0 w-full z-50 transition-all duration-500" id="header">
    <div class="header-bg absolute inset-0 bg-black/10 backdrop-blur-lg border-b border-white/10 opacity-0 transition-opacity duration-300"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center animate-fade-in group cursor-pointer">
                <div
                    class="w-12 h-12 bg-gradient-to-r from-orange-custom to-red-500 rounded-full flex items-center justify-center mr-3 shadow-lg transform group-hover:rotate-12 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <span class="text-2xl font-bold text-white drop-shadow-lg">SafariConnect</span>
                    <p class="text-xs text-white/70 -mt-1">Your Journey, Our Priority</p>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="#hero-section"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">HOME</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#service-cards"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">SERVICES</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#features"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">HOW IT WORKS</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">PRICING</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">ABOUT</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#footer"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">CONTACT</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-custom to-red-500 transition-all group-hover:w-full"></span>
                </a>
            </nav>

            <!-- Account Button & Mobile Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- User is logged in -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <span class="text-white text-sm">Welcome, {{ auth()->user()->name }}!</span>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gradient-to-r from-brown-custom to-amber-700 hover:from-amber-700 hover:to-brown-custom text-white px-6 py-2 rounded-full font-medium transition-all shadow-lg hover:shadow-xl flex items-center transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                @else
                    <!-- User is not logged in -->
                    <a href="{{ route('login') }}"
                        class="hidden sm:flex bg-gradient-to-r from-brown-custom to-amber-700 hover:from-amber-700 hover:to-brown-custom text-white px-6 py-2 rounded-full font-medium transition-all shadow-lg hover:shadow-xl items-center transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Account
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="lg:hidden text-white p-2" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden fixed inset-x-0 top-20 bg-black/95 backdrop-blur-xl border-t border-white/10 transform -translate-y-full transition-transform duration-300" id="mobile-menu">
        <div class="px-4 pt-4 pb-6 space-y-1">
            <a href="#hero-section" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">HOME</a>
            <a href="#service-cards" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">SERVICES</a>
            <a href="#features" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">HOW IT WORKS</a>
            <a href="#" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">PRICING</a>
            <a href="#" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">ABOUT</a>
            <a href="#footer" class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">CONTACT</a>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full mt-4 bg-gradient-to-r from-brown-custom to-amber-700 text-white px-6 py-2 rounded-full font-medium text-center block">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full mt-4 bg-gradient-to-r from-brown-custom to-amber-700 text-white px-6 py-2 rounded-full font-medium text-center block">
                    Account
                </a>
            @endauth
        </div>
    </div>
</header>
