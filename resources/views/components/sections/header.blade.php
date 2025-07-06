<!-- Header -->
<header class="fixed top-0 left-0 w-full z-50 glass transition-all duration-300" id="header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center animate-fade-in">
                <div
                    class="w-10 h-10 bg-gradient-to-r from-orange-custom to-red-500 rounded-full flex items-center justify-center mr-3 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                        </path>
                    </svg>
                </div>
                <span
                    class="text-xl font-bold bg-gradient-to-r from-orange-custom to-red-500 bg-clip-text text-transparent">SafariConnect</span>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    HOME
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    SERVICES
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    HOW IT WORKS
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    PRICING
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    ABOUT
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
                </a>
                <a href="#"
                    class="text-white hover:text-orange-custom font-medium transition-colors relative group">
                    CONTACT
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-custom transition-all group-hover:w-full"></span>
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
    <div class="lg:hidden hidden glass" id="mobile-menu">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">HOME</a>
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">SERVICES</a>
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">HOW IT WORKS</a>
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">PRICING</a>
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">ABOUT</a>
            <a href="#" class="block text-white hover:text-orange-custom font-medium py-2">CONTACT</a>
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
