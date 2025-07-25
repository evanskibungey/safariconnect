<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafariConnect - Airport Transfers Made Easy</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'orange-custom': '#FF6B35',
                    'brown-custom': '#8B4513',
                    'dark-blue': '#1e293b',
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'slide-up': 'slideUp 0.5s ease-out',
                    'fade-in': 'fadeIn 0.6s ease-out',
                },
                keyframes: {
                    float: {
                        '0%, 100%': {
                            transform: 'translateY(0px)'
                        },
                        '50%': {
                            transform: 'translateY(-20px)'
                        },
                    },
                    slideUp: {
                        '0%': {
                            transform: 'translateY(30px)',
                            opacity: '0'
                        },
                        '100%': {
                            transform: 'translateY(0)',
                            opacity: '1'
                        },
                    },
                    fadeIn: {
                        '0%': {
                            opacity: '0'
                        },
                        '100%': {
                            opacity: '1'
                        },
                    }
                }
            }
        }
    }
    </script>
    <style>
    /* Custom glassmorphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-gradient {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    }

    /* Smooth transitions */
    * {
        transition: all 0.3s ease;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #FF6B35;
        border-radius: 3px;
    }
    </style>
</head>

<body class="bg-gray-50 font-sans overflow-x-hidden">

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

    <!-- Hero Section -->
    <section class="relative h-screen bg-gray-400 overflow-hidden">
        <!-- Car Background Image Simulation -->
        <div class="absolute inset-0">
            <!-- Simulated car background using gradients and shapes -->
            <div class="absolute inset-0 bg-gradient-to-r from-gray-600 via-gray-500 to-gray-400"></div>
            <!-- Car silhouette simulation -->
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-full max-w-4xl h-64">
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-96 h-32 bg-gray-800 rounded-t-3xl">
                </div>
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 w-80 h-20 bg-gray-700 rounded-t-2xl">
                </div>
                <!-- Car windows -->
                <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 w-64 h-12 bg-gray-600 rounded-t-xl">
                </div>
                <!-- Headlights -->
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-x-32 w-8 h-6 bg-yellow-300 rounded-sm opacity-80">
                </div>
                <div
                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-x-24 w-8 h-6 bg-yellow-300 rounded-sm opacity-80">
                </div>
            </div>
            <!-- Road/ground -->
            <div class="absolute bottom-0 w-full h-20 bg-gray-700"></div>
        </div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- 24/7 Service Badge -->
        <div class="absolute top-32 left-1/2 transform -translate-x-1/2 z-30">
            <div class="bg-orange-custom text-white px-6 py-3 rounded-full font-semibold flex items-center shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                        clip-rule="evenodd"></path>
                </svg>
                24/7 Service
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Share Rides, Save Money
                </h1>

                <!-- Subheading -->
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-4xl mx-auto leading-relaxed">
                    Join thousands who are saving up to 50% on intercity travel by sharing rides with verified
                    co-passengers.
                </p>

                <!-- Carousel Indicators -->
                <div class="flex items-center justify-center space-x-3 mb-20">
                    <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition-all"></button>
                    <button class="w-4 h-4 rounded-full bg-orange-custom shadow-lg"></button>
                    <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition-all"></button>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button
            class="absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 z-30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button
            class="absolute right-4 md:right-8 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 z-30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

    </section>

    <!-- Service Cards Section -->
    <section class="relative -mt-16 z-30 pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-4 lg:gap-6">
                <!-- Share Ride Card - Active -->
                <div
                    id="shared-ride-card"
                    class="group bg-brown-custom text-white px-6 py-4 rounded-2xl shadow-xl cursor-pointer transition-all transform hover:scale-105 hover:shadow-2xl min-w-0 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center group-hover:bg-white/30 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                </path>
                                <path
                                    d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg whitespace-nowrap">Share Ride</h3>
                    </div>
                </div>

                <!-- Solo Ride Card -->
                <div
                    id="solo-ride-card"
                    class="group bg-white text-gray-800 px-6 py-4 rounded-2xl shadow-xl cursor-pointer transition-all transform hover:scale-105 hover:shadow-2xl hover:bg-gray-50 min-w-0 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center group-hover:bg-green-500/30 transition-all">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg whitespace-nowrap">Solo Ride</h3>
                    </div>
                </div>

                <!-- Airport Card -->
                <div
                    id="airport-transfer-card"
                    class="group bg-white text-gray-800 px-6 py-4 rounded-2xl shadow-xl cursor-pointer transition-all transform hover:scale-105 hover:shadow-2xl hover:bg-gray-50 min-w-0 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center group-hover:bg-blue-500/30 transition-all">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 018 8v2a2 2 0 01-2 2h-2.28l-.9-2.7c-.16-.48-.61-.8-1.13-.8H8.31c-.52 0-.97.32-1.13.8L6.28 14H4a2 2 0 01-2-2v-2a8 8 0 018-8zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg whitespace-nowrap">Airport</h3>
                    </div>
                </div>

                <!-- Car Hire Card -->
                <div
                    class="group bg-white text-gray-800 px-6 py-4 rounded-2xl shadow-xl cursor-pointer transition-all transform hover:scale-105 hover:shadow-2xl hover:bg-gray-50 min-w-0 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-teal-500/20 rounded-full flex items-center justify-center group-hover:bg-teal-500/30 transition-all">
                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z">
                                </path>
                                <path
                                    d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg whitespace-nowrap">Car Hire</h3>
                    </div>
                </div>

                <!-- Parcel Card -->
                <div
                    class="group bg-white text-gray-800 px-6 py-4 rounded-2xl shadow-xl cursor-pointer transition-all transform hover:scale-105 hover:shadow-2xl hover:bg-gray-50 min-w-0 flex-shrink-0">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-orange-500/20 rounded-full flex items-center justify-center group-hover:bg-orange-500/30 transition-all">
                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg whitespace-nowrap">Parcel</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose SafariConnect?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Experience the difference with our premium features
                    and exceptional service quality</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-xl hover:shadow-lg transition-all">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-orange-custom to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Reliable Service</h3>
                    <p class="text-gray-600">99% on-time performance with professional drivers</p>
                </div>

                <div class="text-center p-6 rounded-xl hover:shadow-lg transition-all">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock customer assistance</p>
                </div>

                <div class="text-center p-6 rounded-xl hover:shadow-lg transition-all">
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Secure Payments</h3>
                    <p class="text-gray-600">Safe and encrypted payment processing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-20 bg-gradient-to-r from-orange-custom via-red-500 to-brown-custom relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute bottom-10 right-20 w-24 h-24 bg-white/10 rounded-full animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Stay Updated with SafariConnect</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Get exclusive offers, travel tips, and be the first
                to know about our new services</p>

            <div class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                <input type="email" placeholder="Enter your email address"
                    class="flex-1 px-6 py-4 rounded-full border-0 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all">
                <button
                    class="bg-white text-orange-custom px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                    Subscribe
                </button>
            </div>

            <p class="text-white/80 text-sm mt-4">No spam, unsubscribe at any time</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-dark-blue text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-40 h-40 bg-orange-custom/5 rounded-full animate-float"></div>
            <div class="absolute bottom-20 right-10 w-32 h-32 bg-blue-500/5 rounded-full animate-float"
                style="animation-delay: 3s;"></div>
        </div>

        <!-- Main Footer Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

                <!-- Company Info -->
                <div class="lg:col-span-1">
                    <!-- Logo -->
                    <div class="flex items-center mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-orange-custom to-red-500 rounded-full flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-orange-custom to-red-500 bg-clip-text text-transparent">SafariConnect</span>
                    </div>

                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Your trusted partner for premium airport transfers and transportation services. Safe, reliable,
                        and comfortable journeys every time.
                    </p>

                    <!-- Contact Info -->
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-custom/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-gray-300">+1 (555) 123-4567</span>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-custom/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                    </path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300">info@safariconnect.com</span>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-custom/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-300">123 Transport Ave, City</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Home
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                About Us
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Our Fleet
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Pricing
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Contact
                            </a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white">Our Services</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Airport Transfers
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                City Rides
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Car Rental
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Corporate Travel
                            </a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-orange-custom transition-colors flex items-center group">
                                <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Parcel Delivery
                            </a></li>
                    </ul>
                </div>

                <!-- Support & Social -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-white">Connect With Us</h3>

                    <!-- Social Media -->
                    <div class="mb-8">
                        <p class="text-gray-300 mb-4">Follow us on social media</p>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-blue-400 hover:bg-blue-500 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84">
                                    </path>
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-pink-600 hover:bg-pink-700 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-blue-700 hover:bg-blue-800 rounded-full flex items-center justify-center transition-all transform hover:scale-110">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- App Download -->
                    <div>
                        <p class="text-gray-300 mb-4">Download our mobile app</p>
                        <div class="space-y-3">
                            <a href="#"
                                class="inline-flex items-center bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-105">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" />
                                </svg>
                                <div class="text-left">
                                    <div class="text-xs">Download on the</div>
                                    <div class="text-sm font-semibold">App Store</div>
                                </div>
                            </a>
                            <a href="#"
                                class="inline-flex items-center bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-105">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" />
                                </svg>
                                <div class="text-left">
                                    <div class="text-xs">Get it on</div>
                                    <div class="text-sm font-semibold">Google Play</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods & Trust Badges -->
        <div class="border-t border-gray-700 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                    <!-- Payment Methods -->
                    <div class="flex flex-col items-center md:items-start">
                        <p class="text-gray-300 text-sm mb-3">Secure Payment Methods</p>
                        <div class="flex items-center space-x-4">
                            <div class="bg-white rounded px-3 py-2">
                                <span class="text-blue-600 font-bold text-sm">VISA</span>
                            </div>
                            <div class="bg-white rounded px-3 py-2">
                                <span class="text-orange-500 font-bold text-sm">MC</span>
                            </div>
                            <div class="bg-white rounded px-3 py-2">
                                <span class="text-blue-700 font-bold text-sm">AMEX</span>
                            </div>
                            <div class="bg-white rounded px-3 py-2">
                                <span class="text-green-600 font-bold text-sm">PayPal</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex flex-col items-center md:items-end">
                        <p class="text-gray-300 text-sm mb-3">Certified & Trusted</p>
                        <div class="flex items-center space-x-4">
                            <div class="bg-green-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                SSL SECURED
                            </div>
                            <div class="bg-blue-600 text-white px-3 py-2 rounded text-xs font-semibold">
                                24/7 SUPPORT
                            </div>
                            <div class="bg-orange-custom text-white px-3 py-2 rounded text-xs font-semibold">
                                VERIFIED
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <!-- Copyright -->
                    <div class="text-gray-400 text-sm">
                        © 2024 SafariConnect. All rights reserved. | Designed with ❤️ for better travel
                    </div>

                    <!-- Legal Links -->
                    <div class="flex items-center space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-orange-custom transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-orange-custom transition-colors">Terms of
                            Service</a>
                        <a href="#" class="text-gray-400 hover:text-orange-custom transition-colors">Cookie Policy</a>
                        <a href="#" class="text-gray-400 hover:text-orange-custom transition-colors">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Shared Ride Booking Modal -->
    <div id="shared-ride-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-brown-custom to-amber-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Book Your Shared Ride</h3>
                        <button id="close-modal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="shared-ride-form" class="px-6 py-6">
                    @csrf
                    
                    <!-- Form Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Left Column: Trip Details -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                    Trip Details
                                </h4>
                                
                                <!-- Route Selection -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="pickup_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                Pickup City <span class="text-red-500">*</span>
                                            </label>
                                            <select id="pickup_city" name="pickup_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                                <option value="">Select pickup city</option>
                                                <!-- Options will be populated via AJAX -->
                                            </select>
                                        </div>

                                        <div>
                                            <label for="dropoff_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                Drop-off City <span class="text-red-500">*</span>
                                            </label>
                                            <select id="dropoff_city" name="dropoff_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                                <option value="">Select drop-off city</option>
                                                <!-- Options will be populated via AJAX -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Travel Details -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label for="travel_date" class="block text-sm font-medium text-gray-700 mb-2">
                                                Travel Date <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" id="travel_date" name="travel_date" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                                required min="{{ date('Y-m-d') }}">
                                        </div>

                                        <div>
                                            <label for="travel_time" class="block text-sm font-medium text-gray-700 mb-2">
                                                Preferred Time <span class="text-red-500">*</span>
                                            </label>
                                            <input type="time" id="travel_time" name="travel_time" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                                required>
                                        </div>

                                        <div>
                                            <label for="passengers" class="block text-sm font-medium text-gray-700 mb-2">
                                                Passengers <span class="text-red-500">*</span>
                                            </label>
                                            <select id="passengers" name="passengers" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" required>
                                                <option value="1">1 Passenger</option>
                                                <option value="2">2 Passengers</option>
                                                <option value="3">3 Passengers</option>
                                                <option value="4">4 Passengers</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Display -->
                            <div id="price-display" class="hidden p-4 bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Estimated Price:</span>
                                    <span id="price-amount" class="text-2xl font-bold text-orange-custom"></span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Price per passenger for shared ride</p>
                            </div>
                        </div>
                        
                        <!-- Right Column: Contact & Account Information -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Contact Information
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="customer_name" name="customer_name" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required>
                                    </div>

                                    <div>
                                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="customer_email" name="customer_email" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required>
                                        <p class="text-xs text-gray-500 mt-1">We'll use this for your account login and booking updates</p>
                                    </div>

                                    <div>
                                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="customer_phone" name="customer_phone" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            placeholder="+254 7XX XXX XXX" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Account Password Section -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-custom" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Account Password
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="password" name="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-custom focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" id="cancel-booking" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-orange-custom to-red-500 text-white rounded-lg hover:from-red-500 hover:to-orange-custom transition-all transform hover:scale-105 shadow-lg font-medium">
                            Complete Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Solo Ride Booking Modal -->
    <div id="solo-ride-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Book Your Solo Ride</h3>
                        <button id="close-solo-modal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="solo-ride-form" class="px-6 py-6">
                    @csrf
                    
                    <!-- Form Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Left Column: Trip Details -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                    Trip Details
                                </h4>
                                
                                <!-- Route Selection -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="solo_pickup_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                Pickup City <span class="text-red-500">*</span>
                                            </label>
                                            <select id="solo_pickup_city" name="pickup_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                                                <option value="">Select pickup city</option>
                                                <!-- Options will be populated via AJAX -->
                                            </select>
                                        </div>

                                        <div>
                                            <label for="solo_dropoff_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                Drop-off City <span class="text-red-500">*</span>
                                            </label>
                                            <select id="solo_dropoff_city" name="dropoff_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                                                <option value="">Select drop-off city</option>
                                                <!-- Options will be populated via AJAX -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Vehicle Type Selection -->
                                    <div>
                                        <label for="solo_vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                                            Vehicle Type <span class="text-red-500">*</span>
                                        </label>
                                        <select id="solo_vehicle_type" name="vehicle_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                                            <option value="">Select vehicle type</option>
                                            <!-- Options will be populated via AJAX -->
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Choose your preferred vehicle for your solo journey</p>
                                    </div>

                                    <!-- Travel Details -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label for="solo_travel_date" class="block text-sm font-medium text-gray-700 mb-2">
                                                Travel Date <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" id="solo_travel_date" name="travel_date" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                                required min="{{ date('Y-m-d') }}">
                                        </div>

                                        <div>
                                            <label for="solo_travel_time" class="block text-sm font-medium text-gray-700 mb-2">
                                                Preferred Time <span class="text-red-500">*</span>
                                            </label>
                                            <input type="time" id="solo_travel_time" name="travel_time" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                                required>
                                        </div>

                                        <div>
                                            <label for="solo_passengers" class="block text-sm font-medium text-gray-700 mb-2">
                                                Passengers <span class="text-red-500">*</span>
                                            </label>
                                            <select id="solo_passengers" name="passengers" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" required>
                                                <option value="1">1 Passenger</option>
                                                <option value="2">2 Passengers</option>
                                                <option value="3">3 Passengers</option>
                                                <option value="4">4 Passengers</option>
                                                <option value="5">5 Passengers</option>
                                                <option value="6">6+ Passengers</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Display -->
                            <div id="solo-price-display" class="hidden p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Total Price:</span>
                                    <span id="solo-price-amount" class="text-2xl font-bold text-green-600"></span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Private vehicle for your exclusive use</p>
                            </div>
                        </div>
                        
                        <!-- Right Column: Contact & Account Information -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Contact Information
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="solo_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="solo_customer_name" name="customer_name" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                            required>
                                    </div>

                                    <div>
                                        <label for="solo_customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="solo_customer_email" name="customer_email" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                            required>
                                        <p class="text-xs text-gray-500 mt-1">We'll use this for your account login and booking updates</p>
                                    </div>

                                    <div>
                                        <label for="solo_customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="solo_customer_phone" name="customer_phone" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                            placeholder="+254 7XX XXX XXX" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Account Password Section -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Account Password
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="solo_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="solo_password" name="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                    </div>
                                    
                                    <div>
                                        <label for="solo_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="solo_password_confirmation" name="password_confirmation" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Special Requirements -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    Special Requirements
                                </h4>
                                
                                <div>
                                    <label for="solo_special_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                                        Additional Notes (Optional)
                                    </label>
                                    <textarea id="solo_special_requirements" name="special_requirements" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent" 
                                        placeholder="Any special requirements, luggage details, or additional information..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" id="cancel-solo-booking" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-lg hover:from-emerald-700 hover:to-green-600 transition-all transform hover:scale-105 shadow-lg font-medium">
                            Complete Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Airport Transfer Booking Modal -->
    <div id="airport-transfer-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-cyan-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Book Your Airport Transfer</h3>
                        <button id="close-airport-modal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="airport-transfer-form" class="px-6 py-6">
                    @csrf
                    
                    <!-- Transfer Type Selection -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Transfer Type
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="radio" id="pickup_transfer" name="transfer_type" value="pickup" class="sr-only" required>
                                <label for="pickup_transfer" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-800">Airport Pickup</h5>
                                            <p class="text-sm text-gray-600">From airport to your destination</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="relative">
                                <input type="radio" id="dropoff_transfer" name="transfer_type" value="dropoff" class="sr-only" required>
                                <label for="dropoff_transfer" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-all transfer-type-option">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-cyan-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                                <path d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 14.846 4.632 16 6.414 16H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-800">Airport Drop-off</h5>
                                            <p class="text-sm text-gray-600">From your location to airport</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Left Column: Trip Details -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Trip Details
                                </h4>
                                
                                <!-- Route Selection -->
                                <div class="space-y-4">
                                    <!-- Airport Pickup Route -->
                                    <div id="pickup-route" class="hidden route-section">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="pickup_airport" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Pickup Airport <span class="text-red-500">*</span>
                                                </label>
                                                <select id="pickup_airport" name="pickup_airport_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                    <option value="">Select pickup airport</option>
                                                    <!-- Options will be populated via AJAX -->
                                                </select>
                                            </div>

                                            <div>
                                                <label for="destination_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Destination City <span class="text-red-500">*</span>
                                                </label>
                                                <select id="destination_city" name="dropoff_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                    <option value="">Select destination city</option>
                                                    <!-- Options will be populated via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Airport Drop-off Route -->
                                    <div id="dropoff-route" class="hidden route-section">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="origin_city" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Origin City <span class="text-red-500">*</span>
                                                </label>
                                                <select id="origin_city" name="pickup_city_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                    <option value="">Select origin city</option>
                                                    <!-- Options will be populated via AJAX -->
                                                </select>
                                            </div>

                                            <div>
                                                <label for="dropoff_airport" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Drop-off Airport <span class="text-red-500">*</span>
                                                </label>
                                                <select id="dropoff_airport" name="dropoff_airport_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                                    <option value="">Select drop-off airport</option>
                                                    <!-- Options will be populated via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vehicle Type Selection -->
                                    <div>
                                        <label for="airport_vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                                            Vehicle Type <span class="text-red-500">*</span>
                                        </label>
                                        <select id="airport_vehicle_type" name="vehicle_type_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" required>
                                            <option value="">Select vehicle type</option>
                                            <!-- Options will be populated via AJAX -->
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Choose your preferred vehicle for airport transfer</p>
                                    </div>

                                    <!-- Travel Details -->
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label for="airport_travel_date" class="block text-sm font-medium text-gray-700 mb-2">
                                                Travel Date <span class="text-red-500">*</span>
                                            </label>
                                            <input type="date" id="airport_travel_date" name="travel_date" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                                required min="{{ date('Y-m-d') }}">
                                        </div>

                                        <div>
                                            <label for="airport_travel_time" class="block text-sm font-medium text-gray-700 mb-2">
                                                Preferred Time <span class="text-red-500">*</span>
                                            </label>
                                            <input type="time" id="airport_travel_time" name="travel_time" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                                required>
                                        </div>

                                        <div>
                                            <label for="airport_passengers" class="block text-sm font-medium text-gray-700 mb-2">
                                                Passengers <span class="text-red-500">*</span>
                                            </label>
                                            <select id="airport_passengers" name="passengers" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" required>
                                                <option value="1">1 Passenger</option>
                                                <option value="2">2 Passengers</option>
                                                <option value="3">3 Passengers</option>
                                                <option value="4">4 Passengers</option>
                                                <option value="5">5 Passengers</option>
                                                <option value="6">6 Passengers</option>
                                                <option value="7">7 Passengers</option>
                                                <option value="8">8 Passengers</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Flight Details -->
                                    <div>
                                        <label for="flight_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            Flight Number (Optional)
                                        </label>
                                        <input type="text" id="flight_number" name="flight_number" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            placeholder="e.g., KQ101">
                                        <p class="text-xs text-gray-500 mt-1">Helps us track your flight and adjust pickup time if needed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Display -->
                            <div id="airport-price-display" class="hidden p-4 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">Total Price:</span>
                                    <span id="airport-price-amount" class="text-2xl font-bold text-blue-600"></span>
                                </div>
                                <div id="airport-price-breakdown" class="text-sm text-gray-600 mt-2">
                                    <!-- Price breakdown will be shown here -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column: Contact & Account Information -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Contact Information
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="airport_customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="airport_customer_name" name="customer_name" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            required>
                                    </div>

                                    <div>
                                        <label for="airport_customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="airport_customer_email" name="customer_email" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            required>
                                        <p class="text-xs text-gray-500 mt-1">We'll use this for your account login and booking updates</p>
                                    </div>

                                    <div>
                                        <label for="airport_customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="tel" id="airport_customer_phone" name="customer_phone" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            placeholder="+254 7XX XXX XXX" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Account Password Section -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Account Password
                                </h4>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="airport_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="airport_password" name="password" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Minimum 4 characters</p>
                                    </div>
                                    
                                    <div>
                                        <label for="airport_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" id="airport_password_confirmation" name="password_confirmation" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                            required minlength="4">
                                        <p class="text-xs text-gray-500 mt-1">Re-enter your password to confirm</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Special Requirements -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    Special Requirements
                                </h4>
                                
                                <div>
                                    <label for="airport_special_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                                        Additional Notes (Optional)
                                    </label>
                                    <textarea id="airport_special_requirements" name="special_requirements" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
                                        placeholder="Any special requirements, luggage details, or additional information..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" id="cancel-airport-booking" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-700 text-white rounded-lg hover:from-cyan-700 hover:to-blue-600 transition-all transform hover:scale-105 shadow-lg font-medium">
                            Complete Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for interactivity -->
    <script>
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Header scroll effect
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            header.classList.add('bg-slate-800/95');
            header.classList.remove('glass');
        } else {
            header.classList.remove('bg-slate-800/95');
            header.classList.add('glass');
        }
    });

    // Carousel functionality
    const indicators = document.querySelectorAll('button[class*="w-3 h-3"], button[class*="w-4 h-4"]');
    const slides = ['Airport Transfers Made Easy', 'Reliable City Transport', 'Premium Car Hire Services'];
    let currentSlide = 2; // Starting with the third slide (orange indicator)

    function updateSlide(index) {
        indicators.forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('bg-orange-custom', 'w-4', 'h-4', 'shadow-lg');
                indicator.classList.remove('bg-gray-400', 'w-3', 'h-3');
            } else {
                indicator.classList.remove('bg-orange-custom', 'w-4', 'h-4', 'shadow-lg');
                indicator.classList.add('bg-gray-400', 'w-3', 'h-3');
            }
        });
    }

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateSlide(currentSlide);
        });
    });

    // Navigation arrows
    document.querySelector('button[class*="left-4"]').addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlide(currentSlide);
    });

    document.querySelector('button[class*="right-4"]').addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlide(currentSlide);
    });

    // Auto-advance carousel
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlide(currentSlide);
    }, 7000);

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-slide-up');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('section > div').forEach(el => {
        observer.observe(el);
    });

    // Service card interactions
    const serviceCards = document.querySelectorAll('.group');
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05) translateY(-8px)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1) translateY(0)';
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Shared Ride Modal Functionality
    const sharedRideCard = document.getElementById('shared-ride-card');
    const sharedRideModal = document.getElementById('shared-ride-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelBookingBtn = document.getElementById('cancel-booking');
    const sharedRideForm = document.getElementById('shared-ride-form');
    const pickupCitySelect = document.getElementById('pickup_city');
    const dropoffCitySelect = document.getElementById('dropoff_city');
    const priceDisplay = document.getElementById('price-display');
    const priceAmount = document.getElementById('price-amount');

    // Open modal when shared ride card is clicked
    sharedRideCard.addEventListener('click', () => {
        sharedRideModal.classList.remove('hidden');
        loadCities();
    });

    // Close modal
    function closeModal() {
        sharedRideModal.classList.add('hidden');
        sharedRideForm.reset();
        priceDisplay.classList.add('hidden');
        
        // Clear password validation errors
        const passwordError = document.getElementById('password-error');
        if (passwordError) {
            passwordError.remove();
        }
        
        // Remove error styling from password fields
        const passwordField = document.getElementById('password');
        const passwordConfirmField = document.getElementById('password_confirmation');
        if (passwordField) passwordField.classList.remove('border-red-500');
        if (passwordConfirmField) passwordConfirmField.classList.remove('border-red-500');
    }

    closeModalBtn.addEventListener('click', closeModal);
    cancelBookingBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    sharedRideModal.addEventListener('click', (e) => {
        if (e.target === sharedRideModal) {
            closeModal();
        }
    });

    // Load cities for dropdowns
    async function loadCities() {
        try {
            const response = await fetch('/api/cities');
            if (response.ok) {
                const cities = await response.json();
                populateCityDropdowns(cities);
            }
        } catch (error) {
            console.error('Error loading cities:', error);
            // Fallback: populate with sample cities
            const sampleCities = [
                { id: 1, name: 'Nairobi' },
                { id: 2, name: 'Mombasa' },
                { id: 3, name: 'Kisumu' },
                { id: 4, name: 'Nakuru' },
                { id: 5, name: 'Eldoret' }
            ];
            populateCityDropdowns(sampleCities);
        }
    }

    function populateCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');

        pickupCitySelect.innerHTML = '<option value="">Select pickup city</option>' + cityOptions;
        dropoffCitySelect.innerHTML = '<option value="">Select drop-off city</option>' + cityOptions;
    }

    // Check pricing when cities are selected
    async function checkPricing() {
        const pickupCityId = pickupCitySelect.value;
        const dropoffCityId = dropoffCitySelect.value;

        if (pickupCityId && dropoffCityId && pickupCityId !== dropoffCityId) {
            try {
                const response = await fetch(`/api/shared-ride/pricing?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        priceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        priceDisplay.classList.remove('hidden');
                    } else {
                        priceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking price:', error);
                // Show sample price for demonstration
                priceAmount.textContent = 'KSh 1,500';
                priceDisplay.classList.remove('hidden');
            }
        } else {
            priceDisplay.classList.add('hidden');
        }
    }

    pickupCitySelect.addEventListener('change', checkPricing);
    dropoffCitySelect.addEventListener('change', checkPricing);

    // Password validation
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        const password = passwordField.value;
        const passwordConfirm = passwordConfirmField.value;
        
        // Remove any existing error styles
        passwordField.classList.remove('border-red-500');
        passwordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            passwordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            passwordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            passwordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation
    passwordField.addEventListener('input', validatePasswords);
    passwordConfirmField.addEventListener('input', validatePasswords);

    // Handle form submission
    sharedRideForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Validate same city selection
        if (pickupCitySelect.value === dropoffCitySelect.value) {
            alert('Please select different cities for pickup and drop-off.');
            return;
        }
        
        // Validate passwords
        if (!validatePasswords()) {
            return;
        }

        // Collect form data
        const formData = new FormData(sharedRideForm);
        const bookingData = Object.fromEntries(formData);

        // Show loading state
        const submitBtn = sharedRideForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Processing...';
        submitBtn.disabled = true;

        try {
            // Make actual API call
            const response = await fetch('/api/shared-ride/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(bookingData)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // Success message with booking reference and account info
                let successMessage;
                
                if (result.account_created) {
                    successMessage = `🎉 Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details.`;
                } else {
                    successMessage = `🎉 Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details.`;
                }
                
                alert(successMessage);
                closeModal();
                
                // Refresh the page to show the updated header with user info
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Handle errors
                if (result.errors) {
                    // Handle form validation errors
                    let errorMessage = 'Please fix the following issues:\n\n';
                    
                    // Check for specific field errors
                    if (result.errors.customer_email) {
                        errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                    }
                    if (result.errors.password) {
                        errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                    }
                    if (result.errors.customer_phone) {
                        errorMessage += '📱 Phone: ' + result.errors.customer_phone.join(', ') + '\n';
                    }
                    
                    // Add other field errors
                    Object.keys(result.errors).forEach(field => {
                        if (!['customer_email', 'password', 'customer_phone'].includes(field)) {
                            errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                        }
                    });
                    
                    alert(errorMessage);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your booking. Please try again.');
                }
            }
        } catch (error) {
            console.error('Booking error:', error);
            alert('Sorry, there was an error processing your booking. Please try again.');
        } finally {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });

    // Set minimum date to today
    document.getElementById('travel_date').min = new Date().toISOString().split('T')[0];
    
    // ===================================
    // SOLO RIDE FUNCTIONALITY
    // ===================================
    
    // Solo Ride Modal Elements
    const soloRideCard = document.getElementById('solo-ride-card');
    const soloRideModal = document.getElementById('solo-ride-modal');
    const closeSoloModalBtn = document.getElementById('close-solo-modal');
    const cancelSoloBookingBtn = document.getElementById('cancel-solo-booking');
    const soloRideForm = document.getElementById('solo-ride-form');
    const soloPickupCitySelect = document.getElementById('solo_pickup_city');
    const soloDropoffCitySelect = document.getElementById('solo_dropoff_city');
    const soloVehicleTypeSelect = document.getElementById('solo_vehicle_type');
    const soloPriceDisplay = document.getElementById('solo-price-display');
    const soloPriceAmount = document.getElementById('solo-price-amount');
    
    // Open solo ride modal when card is clicked
    soloRideCard.addEventListener('click', () => {
        soloRideModal.classList.remove('hidden');
        loadSoloRideData();
    });
    
    // Close solo ride modal
    function closeSoloModal() {
        soloRideModal.classList.add('hidden');
        soloRideForm.reset();
        soloPriceDisplay.classList.add('hidden');
        
        // Clear password validation errors
        const passwordError = document.getElementById('solo-password-error');
        if (passwordError) {
            passwordError.remove();
        }
        
        // Remove error styling from password fields
        const passwordField = document.getElementById('solo_password');
        const passwordConfirmField = document.getElementById('solo_password_confirmation');
        if (passwordField) passwordField.classList.remove('border-red-500');
        if (passwordConfirmField) passwordConfirmField.classList.remove('border-red-500');
    }
    
    closeSoloModalBtn.addEventListener('click', closeSoloModal);
    cancelSoloBookingBtn.addEventListener('click', closeSoloModal);
    
    // Close modal when clicking outside
    soloRideModal.addEventListener('click', (e) => {
        if (e.target === soloRideModal) {
            closeSoloModal();
        }
    });
    
    // Load data for solo ride (cities and vehicle types)
    async function loadSoloRideData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateSoloCityDropdowns(cities);
            }
            
            // Load vehicle types
            const vehicleTypesResponse = await fetch('/api/vehicle-types');
            if (vehicleTypesResponse.ok) {
                const vehicleTypes = await vehicleTypesResponse.json();
                populateSoloVehicleTypes(vehicleTypes);
            } else {
                // Fallback: populate with sample vehicle types
                const sampleVehicleTypes = [
                    { id: 1, name: 'Economy Car', description: 'Affordable and efficient' },
                    { id: 2, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                    { id: 3, name: 'SUV', description: 'Spacious and versatile' },
                    { id: 4, name: 'Premium Car', description: 'Luxury and comfort' },
                    { id: 5, name: 'Van', description: 'For large groups' }
                ];
                populateSoloVehicleTypes(sampleVehicleTypes);
            }
        } catch (error) {
            console.error('Error loading solo ride data:', error);
            // Fallback: populate with sample data
            const sampleCities = [
                { id: 1, name: 'Nairobi' },
                { id: 2, name: 'Mombasa' },
                { id: 3, name: 'Kisumu' },
                { id: 4, name: 'Nakuru' },
                { id: 5, name: 'Eldoret' }
            ];
            const sampleVehicleTypes = [
                { id: 1, name: 'Economy Car', description: 'Affordable and efficient' },
                { id: 2, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                { id: 3, name: 'SUV', description: 'Spacious and versatile' },
                { id: 4, name: 'Premium Car', description: 'Luxury and comfort' },
                { id: 5, name: 'Van', description: 'For large groups' }
            ];
            populateSoloCityDropdowns(sampleCities);
            populateSoloVehicleTypes(sampleVehicleTypes);
        }
    }
    
    function populateSoloCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        soloPickupCitySelect.innerHTML = '<option value="">Select pickup city</option>' + cityOptions;
        soloDropoffCitySelect.innerHTML = '<option value="">Select drop-off city</option>' + cityOptions;
    }
    
    function populateSoloVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}${vehicle.description ? ' - ' + vehicle.description : ''}</option>`
        ).join('');
        
        soloVehicleTypeSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
    }
    
    // Check solo ride pricing when required fields are selected
    async function checkSoloRidePricing() {
        const pickupCityId = soloPickupCitySelect.value;
        const dropoffCityId = soloDropoffCitySelect.value;
        const vehicleTypeId = soloVehicleTypeSelect.value;
        
        if (pickupCityId && dropoffCityId && vehicleTypeId && pickupCityId !== dropoffCityId) {
            try {
                const response = await fetch(`/api/solo-ride/pricing?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}&vehicle_type_id=${vehicleTypeId}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        soloPriceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        soloPriceDisplay.classList.remove('hidden');
                    } else {
                        soloPriceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking solo ride price:', error);
                // Show sample price for demonstration
                const basePrices = { 1: 2500, 2: 3500, 3: 4500, 4: 6000, 5: 7000 };
                const samplePrice = basePrices[vehicleTypeId] || 3000;
                soloPriceAmount.textContent = `KSh ${samplePrice.toLocaleString()}`;
                soloPriceDisplay.classList.remove('hidden');
            }
        } else {
            soloPriceDisplay.classList.add('hidden');
        }
    }
    
    soloPickupCitySelect.addEventListener('change', checkSoloRidePricing);
    soloDropoffCitySelect.addEventListener('change', checkSoloRidePricing);
    soloVehicleTypeSelect.addEventListener('change', checkSoloRidePricing);
    
    // Solo ride password validation
    const soloPasswordField = document.getElementById('solo_password');
    const soloPasswordConfirmField = document.getElementById('solo_password_confirmation');
    
    function validateSoloPasswords() {
        const password = soloPasswordField.value;
        const passwordConfirm = soloPasswordConfirmField.value;
        
        // Remove any existing error styles
        soloPasswordField.classList.remove('border-red-500');
        soloPasswordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('solo-password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            soloPasswordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            soloPasswordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'solo-password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            soloPasswordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation for solo ride
    soloPasswordField.addEventListener('input', validateSoloPasswords);
    soloPasswordConfirmField.addEventListener('input', validateSoloPasswords);
    
    // Handle solo ride form submission
    soloRideForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Validate same city selection
        if (soloPickupCitySelect.value === soloDropoffCitySelect.value) {
            alert('Please select different cities for pickup and drop-off.');
            return;
        }
        
        // Validate passwords
        if (!validateSoloPasswords()) {
            return;
        }
        
        // Collect form data
        const formData = new FormData(soloRideForm);
        const bookingData = Object.fromEntries(formData);
        
        // Show loading state
        const submitBtn = soloRideForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Processing...';
        submitBtn.disabled = true;
        
        try {
            // Make actual API call
            const response = await fetch('/api/solo-ride/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(bookingData)
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Success message with booking reference and account info
                let successMessage;
                
                if (result.account_created) {
                    successMessage = `🎉 Solo Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                } else {
                    successMessage = `🎉 Solo Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                }
                
                alert(successMessage);
                closeSoloModal();
                
                // Refresh the page to show the updated header with user info
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Handle errors
                if (result.errors) {
                    // Handle form validation errors
                    let errorMessage = 'Please fix the following issues:\n\n';
                    
                    // Check for specific field errors
                    if (result.errors.customer_email) {
                        errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                    }
                    if (result.errors.password) {
                        errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                    }
                    if (result.errors.customer_phone) {
                        errorMessage += '📱 Phone: ' + result.errors.customer_phone.join(', ') + '\n';
                    }
                    if (result.errors.vehicle_type_id) {
                        errorMessage += '🚗 Vehicle Type: ' + result.errors.vehicle_type_id.join(', ') + '\n';
                    }
                    
                    // Add other field errors
                    Object.keys(result.errors).forEach(field => {
                        if (!['customer_email', 'password', 'customer_phone', 'vehicle_type_id'].includes(field)) {
                            errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                        }
                    });
                    
                    alert(errorMessage);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your solo ride booking. Please try again.');
                }
            }
        } catch (error) {
            console.error('Solo ride booking error:', error);
            alert('Sorry, there was an error processing your solo ride booking. Please try again.');
        } finally {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
    
    // Set minimum date to today for solo ride
    document.getElementById('solo_travel_date').min = new Date().toISOString().split('T')[0];
    
    // ===================================
    // AIRPORT TRANSFER FUNCTIONALITY
    // ===================================
    
    // Airport Transfer Modal Elements
    const airportTransferCard = document.getElementById('airport-transfer-card');
    const airportTransferModal = document.getElementById('airport-transfer-modal');
    const closeAirportModalBtn = document.getElementById('close-airport-modal');
    const cancelAirportBookingBtn = document.getElementById('cancel-airport-booking');
    const airportTransferForm = document.getElementById('airport-transfer-form');
    const airportPriceDisplay = document.getElementById('airport-price-display');
    const airportPriceAmount = document.getElementById('airport-price-amount');
    const airportPriceBreakdown = document.getElementById('airport-price-breakdown');
    
    // Transfer type radio buttons
    const pickupTransferRadio = document.getElementById('pickup_transfer');
    const dropoffTransferRadio = document.getElementById('dropoff_transfer');
    
    // Route sections
    const pickupRouteSection = document.getElementById('pickup-route');
    const dropoffRouteSection = document.getElementById('dropoff-route');
    
    // Form elements
    const pickupAirportSelect = document.getElementById('pickup_airport');
    const destinationCitySelect = document.getElementById('destination_city');
    const originCitySelect = document.getElementById('origin_city');
    const dropoffAirportSelect = document.getElementById('dropoff_airport');
    const airportVehicleTypeSelect = document.getElementById('airport_vehicle_type');
    
    // Open airport transfer modal when card is clicked
    airportTransferCard.addEventListener('click', () => {
        airportTransferModal.classList.remove('hidden');
        loadAirportTransferData();
    });
    
    // Close airport transfer modal
    function closeAirportModal() {
        airportTransferModal.classList.add('hidden');
        airportTransferForm.reset();
        airportPriceDisplay.classList.add('hidden');
        
        // Hide all route sections
        pickupRouteSection.classList.add('hidden');
        dropoffRouteSection.classList.add('hidden');
        
        // Clear transfer type selections
        document.querySelectorAll('.transfer-type-option').forEach(option => {
            option.classList.remove('border-blue-500', 'bg-blue-50');
            option.classList.add('border-gray-200');
        });
        
        // Clear password validation errors
        const passwordError = document.getElementById('airport-password-error');
        if (passwordError) {
            passwordError.remove();
        }
        
        // Remove error styling from password fields
        const passwordField = document.getElementById('airport_password');
        const passwordConfirmField = document.getElementById('airport_password_confirmation');
        if (passwordField) passwordField.classList.remove('border-red-500');
        if (passwordConfirmField) passwordConfirmField.classList.remove('border-red-500');
    }
    
    closeAirportModalBtn.addEventListener('click', closeAirportModal);
    cancelAirportBookingBtn.addEventListener('click', closeAirportModal);
    
    // Close modal when clicking outside
    airportTransferModal.addEventListener('click', (e) => {
        if (e.target === airportTransferModal) {
            closeAirportModal();
        }
    });
    
    // Transfer type selection handling
    pickupTransferRadio.addEventListener('change', function() {
        if (this.checked) {
            pickupRouteSection.classList.remove('hidden');
            dropoffRouteSection.classList.add('hidden');
            updateTransferTypeStyles(this);
            checkAirportTransferPricing();
        }
    });
    
    dropoffTransferRadio.addEventListener('change', function() {
        if (this.checked) {
            dropoffRouteSection.classList.remove('hidden');
            pickupRouteSection.classList.add('hidden');
            updateTransferTypeStyles(this);
            checkAirportTransferPricing();
        }
    });
    
    function updateTransferTypeStyles(selectedRadio) {
        // Reset all styles
        document.querySelectorAll('.transfer-type-option').forEach(option => {
            option.classList.remove('border-blue-500', 'bg-blue-50');
            option.classList.add('border-gray-200');
        });
        
        // Apply selected styles
        const selectedLabel = selectedRadio.nextElementSibling;
        selectedLabel.classList.remove('border-gray-200');
        selectedLabel.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    // Load data for airport transfer
    async function loadAirportTransferData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateAirportCityDropdowns(cities);
            }
            
            // Load airports
            const airportsResponse = await fetch('/api/airports');
            if (airportsResponse.ok) {
                const airports = await airportsResponse.json();
                populateAirportDropdowns(airports);
            }
            
            // Load vehicle types
            const vehicleTypesResponse = await fetch('/api/vehicle-types');
            if (vehicleTypesResponse.ok) {
                const vehicleTypes = await vehicleTypesResponse.json();
                populateAirportVehicleTypes(vehicleTypes);
            } else {
                // Fallback: populate with sample vehicle types
                const sampleVehicleTypes = [
                    { id: 1, name: 'Economy Car', description: 'Affordable and efficient' },
                    { id: 2, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                    { id: 3, name: 'SUV', description: 'Spacious and versatile' },
                    { id: 4, name: 'Premium Car', description: 'Luxury and comfort' },
                    { id: 5, name: 'Van', description: 'For large groups' }
                ];
                populateAirportVehicleTypes(sampleVehicleTypes);
            }
        } catch (error) {
            console.error('Error loading airport transfer data:', error);
            // Fallback with sample data
            const sampleCities = [
                { id: 1, name: 'Nairobi' },
                { id: 2, name: 'Mombasa' },
                { id: 3, name: 'Kisumu' },
                { id: 4, name: 'Nakuru' },
                { id: 5, name: 'Eldoret' }
            ];
            const sampleAirports = [
                { id: 1, name: 'Jomo Kenyatta International Airport', code: 'NBO', city: { name: 'Nairobi' } },
                { id: 2, name: 'Moi International Airport', code: 'MBA', city: { name: 'Mombasa' } },
                { id: 3, name: 'Kisumu Airport', code: 'KIS', city: { name: 'Kisumu' } }
            ];
            const sampleVehicleTypes = [
                { id: 1, name: 'Economy Car', description: 'Affordable and efficient' },
                { id: 2, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                { id: 3, name: 'SUV', description: 'Spacious and versatile' },
                { id: 4, name: 'Premium Car', description: 'Luxury and comfort' },
                { id: 5, name: 'Van', description: 'For large groups' }
            ];
            populateAirportCityDropdowns(sampleCities);
            populateAirportDropdowns(sampleAirports);
            populateAirportVehicleTypes(sampleVehicleTypes);
        }
    }
    
    function populateAirportCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        destinationCitySelect.innerHTML = '<option value="">Select destination city</option>' + cityOptions;
        originCitySelect.innerHTML = '<option value="">Select origin city</option>' + cityOptions;
    }
    
    function populateAirportDropdowns(airports) {
        const airportOptions = airports.map(airport => 
            `<option value="${airport.id}">${airport.name}${airport.code ? ' (' + airport.code + ')' : ''}</option>`
        ).join('');
        
        pickupAirportSelect.innerHTML = '<option value="">Select pickup airport</option>' + airportOptions;
        dropoffAirportSelect.innerHTML = '<option value="">Select drop-off airport</option>' + airportOptions;
    }
    
    function populateAirportVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}${vehicle.description ? ' - ' + vehicle.description : ''}</option>`
        ).join('');
        
        airportVehicleTypeSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
    }
    
    // Check airport transfer pricing when required fields are selected
    async function checkAirportTransferPricing() {
        const transferType = document.querySelector('input[name="transfer_type"]:checked')?.value;
        const vehicleTypeId = airportVehicleTypeSelect.value;
        
        if (!transferType || !vehicleTypeId) {
            airportPriceDisplay.classList.add('hidden');
            return;
        }
        
        let routeComplete = false;
        let pickupAirportId, dropoffCityId, pickupCityId, dropoffAirportId;
        
        if (transferType === 'pickup') {
            pickupAirportId = pickupAirportSelect.value;
            dropoffCityId = destinationCitySelect.value;
            routeComplete = pickupAirportId && dropoffCityId;
        } else {
            pickupCityId = originCitySelect.value;
            dropoffAirportId = dropoffAirportSelect.value;
            routeComplete = pickupCityId && dropoffAirportId;
        }
        
        if (routeComplete) {
            try {
                const params = new URLSearchParams({
                    transfer_type: transferType,
                    vehicle_type_id: vehicleTypeId
                });
                
                if (transferType === 'pickup') {
                    params.append('pickup_airport_id', pickupAirportId);
                    params.append('dropoff_city_id', dropoffCityId);
                } else {
                    params.append('pickup_city_id', pickupCityId);
                    params.append('dropoff_airport_id', dropoffAirportId);
                }
                
                const response = await fetch(`/api/airport-transfer/pricing?${params}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        airportPriceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        
                        // Show price breakdown
                        let breakdown = `Base price: KSh ${data.base_price.toLocaleString()}`;
                        if (data.airport_surcharge > 0) {
                            breakdown += `<br>Airport surcharge: KSh ${data.airport_surcharge.toLocaleString()}`;
                        }
                        airportPriceBreakdown.innerHTML = breakdown;
                        
                        airportPriceDisplay.classList.remove('hidden');
                    } else {
                        airportPriceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking airport transfer price:', error);
                // Show sample price for demonstration
                const basePrices = { 1: 3000, 2: 4000, 3: 5500, 4: 7000, 5: 8500 };
                const basePrice = basePrices[vehicleTypeId] || 4000;
                const surcharge = transferType === 'pickup' ? 500 : 300;
                const totalPrice = basePrice + surcharge;
                
                airportPriceAmount.textContent = `KSh ${totalPrice.toLocaleString()}`;
                airportPriceBreakdown.innerHTML = `Base price: KSh ${basePrice.toLocaleString()}<br>Airport surcharge: KSh ${surcharge.toLocaleString()}`;
                airportPriceDisplay.classList.remove('hidden');
            }
        } else {
            airportPriceDisplay.classList.add('hidden');
        }
    }
    
    // Add event listeners for pricing updates
    pickupAirportSelect.addEventListener('change', checkAirportTransferPricing);
    destinationCitySelect.addEventListener('change', checkAirportTransferPricing);
    originCitySelect.addEventListener('change', checkAirportTransferPricing);
    dropoffAirportSelect.addEventListener('change', checkAirportTransferPricing);
    airportVehicleTypeSelect.addEventListener('change', checkAirportTransferPricing);
    
    // Airport transfer password validation
    const airportPasswordField = document.getElementById('airport_password');
    const airportPasswordConfirmField = document.getElementById('airport_password_confirmation');
    
    function validateAirportPasswords() {
        const password = airportPasswordField.value;
        const passwordConfirm = airportPasswordConfirmField.value;
        
        // Remove any existing error styles
        airportPasswordField.classList.remove('border-red-500');
        airportPasswordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('airport-password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            airportPasswordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            airportPasswordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'airport-password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            airportPasswordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation for airport transfer
    airportPasswordField.addEventListener('input', validateAirportPasswords);
    airportPasswordConfirmField.addEventListener('input', validateAirportPasswords);
    
    // Handle airport transfer form submission
    airportTransferForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Validate transfer type selection
        const transferType = document.querySelector('input[name="transfer_type"]:checked');
        if (!transferType) {
            alert('Please select a transfer type (pickup or drop-off).');
            return;
        }
        
        // Validate route completion
        if (transferType.value === 'pickup') {
            if (!pickupAirportSelect.value || !destinationCitySelect.value) {
                alert('Please select both pickup airport and destination city.');
                return;
            }
        } else {
            if (!originCitySelect.value || !dropoffAirportSelect.value) {
                alert('Please select both origin city and drop-off airport.');
                return;
            }
        }
        
        // Validate passwords
        if (!validateAirportPasswords()) {
            return;
        }
        
        // Collect form data
        const formData = new FormData(airportTransferForm);
        const bookingData = Object.fromEntries(formData);
        
        // Show loading state
        const submitBtn = airportTransferForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Processing...';
        submitBtn.disabled = true;
        
        try {
            // Make actual API call
            const response = await fetch('/api/airport-transfer/book', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(bookingData)
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Success message with booking reference and account info
                let successMessage;
                
                if (result.account_created) {
                    successMessage = `🎉 Airport Transfer Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                } else {
                    successMessage = `🎉 Airport Transfer Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                }
                
                alert(successMessage);
                closeAirportModal();
                
                // Refresh the page to show the updated header with user info
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Handle errors
                if (result.errors) {
                    // Handle form validation errors
                    let errorMessage = 'Please fix the following issues:\n\n';
                    
                    // Check for specific field errors
                    if (result.errors.customer_email) {
                        errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                    }
                    if (result.errors.password) {
                        errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                    }
                    if (result.errors.customer_phone) {
                        errorMessage += '📱 Phone: ' + result.errors.customer_phone.join(', ') + '\n';
                    }
                    if (result.errors.vehicle_type_id) {
                        errorMessage += '🚗 Vehicle Type: ' + result.errors.vehicle_type_id.join(', ') + '\n';
                    }
                    if (result.errors.transfer_type) {
                        errorMessage += '✈️ Transfer Type: ' + result.errors.transfer_type.join(', ') + '\n';
                    }
                    
                    // Add other field errors
                    Object.keys(result.errors).forEach(field => {
                        if (!['customer_email', 'password', 'customer_phone', 'vehicle_type_id', 'transfer_type'].includes(field)) {
                            errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                        }
                    });
                    
                    alert(errorMessage);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your airport transfer booking. Please try again.');
                }
            }
        } catch (error) {
            console.error('Airport transfer booking error:', error);
            alert('Sorry, there was an error processing your airport transfer booking. Please try again.');
        } finally {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
    
    // Set minimum date to today for airport transfer
    document.getElementById('airport_travel_date').min = new Date().toISOString().split('T')[0];
    </script>

</body>

</html>