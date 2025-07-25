<!-- Header -->
<header class="fixed top-0 left-0 w-full z-50 transition-all duration-500 bg-gradient-to-b from-black/30 to-transparent"
    id="header">
    <div
        class="header-bg absolute inset-0 bg-gradient-to-b from-black/90 to-black/70 backdrop-blur-xl border-b border-white/10 opacity-0 transition-all duration-300 shadow-2xl">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center animate-fade-in group cursor-pointer">
                <!-- SafariConnect Logo - Optimized for 400x150px (2.67:1 ratio) -->
                <div
                    class="h-10 w-24 sm:h-12 sm:w-32 mr-3 shadow-lg transform group-hover:scale-105 transition-transform">
                    <!-- Your SafariConnect Logo -->
                    <img src="{{ asset('images/safarikonnect-logo.png') }}" alt="SafariConnect Logo"
                        class="w-full h-full object-contain" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
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
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-safari to-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#service-cards"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">SERVICES</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-safari to-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#features"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">AMENITIES</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-safari to-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#footer"
                    class="text-white hover:text-orange-custom font-semibold transition-all relative group py-2">
                    <span class="relative z-10">CONTACT US</span>
                    <span
                        class="absolute inset-0 bg-white/10 rounded-lg scale-0 group-hover:scale-100 transition-transform"></span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-safari to-orange-custom transition-all group-hover:w-full"></span>
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
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                </div>
                @else
                <!-- User is not logged in -->
                <button onclick="showLoginModal()"
                    class="hidden sm:flex bg-gradient-to-r from-brown-custom to-amber-700 hover:from-amber-700 hover:to-brown-custom text-white px-6 py-2 rounded-full font-medium transition-all shadow-lg hover:shadow-xl items-center transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Account
                </button>
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
    <div class="lg:hidden fixed inset-x-0 top-20 bg-black/95 backdrop-blur-xl border-t border-white/10 transform -translate-y-full transition-transform duration-300"
        id="mobile-menu">
        <div class="px-4 pt-4 pb-6 space-y-1">
            <a href="#hero-section"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">HOME</a>
            <a href="#service-cards"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">SERVICES</a>
            <a href="#features"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">HOW
                IT WORKS</a>
            <a href="#"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">PRICING</a>
            <a href="#"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">ABOUT</a>
            <a href="#footer"
                class="block text-white hover:text-orange-custom hover:bg-white/10 font-medium py-3 px-4 rounded-lg transition-all">CONTACT</a>
            @auth
            <a href="{{ route('dashboard') }}"
                class="w-full mt-4 bg-gradient-to-r from-brown-custom to-amber-700 text-white px-6 py-2 rounded-full font-medium text-center block">
                Dashboard
            </a>
            @else
            <button onclick="showLoginModal()"
                class="w-full mt-4 bg-gradient-to-r from-brown-custom to-amber-700 text-white px-6 py-2 rounded-full font-medium text-center block">
                Account
            </button>
            @endauth
        </div>
    </div>
</header>