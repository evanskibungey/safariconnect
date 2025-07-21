<!-- Hero Section -->
<section class="relative h-screen overflow-hidden pt-20" id="hero-section">
    <!-- Background Image Carousel -->
    <div class="absolute inset-0" id="carousel-container">
        <!-- Slide 1: Modern City Transport -->
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-100" data-slide="0">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>
        </div>

        <!-- Slide 2: Highway Journey -->
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="1">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://plus.unsplash.com/premium_photo-1679830513990-82a4280f41b4?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>
        </div>

        <!-- Slide 3: Safari Adventure -->
        <div class="carousel-slide absolute inset-0 transition-opacity duration-1000 opacity-0" data-slide="2">
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=1168&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/60"></div>
        </div>
    </div>

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating particles -->
        <div class="absolute w-2 h-2 bg-orange-custom/30 rounded-full animate-float-slow" style="top: 20%; left: 10%;">
        </div>
        <div class="absolute w-3 h-3 bg-green-safari/20 rounded-full animate-float-medium" style="top: 60%; left: 80%;">
        </div>
        <div class="absolute w-2 h-2 bg-orange-custom/40 rounded-full animate-float-fast" style="top: 80%; left: 30%;">
        </div>
        <div class="absolute w-4 h-4 bg-green-safari-light/15 rounded-full animate-float-slow"
            style="top: 40%; left: 70%;"></div>
        <div class="absolute w-3 h-3 bg-green-safari/25 rounded-full animate-float-medium" style="top: 25%; left: 85%;">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center -mt-20">
        <div class="text-center animate-fade-in-up">
            <!-- Dynamic Heading Container -->
            <div class="mb-8 relative min-h-[200px]" id="hero-heading-container">
                <!-- Slide 1 Content - Shared Rides -->
                <div class="hero-content transition-all duration-500 opacity-100" data-content="0">
                    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        Scheduled Rides, <span class="text-orange-custom">Perfect Planning</span>
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-4xl mx-auto leading-relaxed">
                        Book your intercity travel in advance with flexible pickup and drop-off points. Share
                        comfortable rides with verified passengers on pre-scheduled routes.
                    </p>
                </div>

                <!-- Slide 2 Content - Airport Transfer -->
                <div class="hero-content absolute top-0 left-0 w-full transition-all duration-500 opacity-0"
                    data-content="1">
                    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        Airport Transfers, <span class="text-orange-custom">Always On Time</span>
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-4xl mx-auto leading-relaxed">
                        Reliable airport pickups and drop-offs with real-time flight tracking. Never miss a flight or
                        wait for a ride again.
                    </p>
                </div>

                <!-- Slide 3 Content - Solo Rides -->
                <div class="hero-content absolute top-0 left-0 w-full transition-all duration-500 opacity-0"
                    data-content="2">
                    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        Private Comfort, <span class="text-orange-custom">Your Way</span>
                    </h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-4xl mx-auto leading-relaxed">
                        Enjoy the luxury of private rides with professional drivers. Travel at your own pace with
                        complete privacy and comfort.
                    </p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8 sm:mt-10 mb-12 sm:mb-16 px-4">
                <a href="#service-cards"
                    class="bg-gradient-to-r from-orange-custom to-red-500 hover:from-red-500 hover:to-orange-custom text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold text-base sm:text-lg transition-all shadow-xl hover:shadow-2xl transform hover:scale-105 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8z" />
                    </svg>
                    Book Your Ride
                </a>
                <a href="#features"
                    class="bg-white/10 backdrop-blur-md border-2 border-white/30 text-white hover:bg-white/20 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-bold text-base sm:text-lg transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                    Explore Services
                </a>
            </div>

            <!-- Carousel Indicators -->
            <div class="flex items-center justify-center space-x-3" id="carousel-indicators">
                <button
                    class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition-all transform hover:scale-125 active"
                    data-slide="0"></button>
                <button
                    class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition-all transform hover:scale-125"
                    data-slide="1"></button>
                <button
                    class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/70 transition-all transform hover:scale-125"
                    data-slide="2"></button>
            </div>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button id="carousel-prev" type="button"
        class="absolute left-4 md:left-8 top-1/2 transform -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-sm hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 z-40 border border-white/20 shadow-xl group">
        <svg class="w-6 h-6 md:w-7 md:h-7 transform group-hover:-translate-x-1 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button id="carousel-next" type="button"
        class="absolute right-4 md:right-8 top-1/2 transform -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-sm hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all hover:scale-110 z-40 border border-white/20 shadow-xl group">
        <svg class="w-6 h-6 md:w-7 md:h-7 transform group-hover:translate-x-1 transition-transform" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-30 animate-bounce">
        <a href="#service-cards" class="text-white/80 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </a>
    </div>
</section>