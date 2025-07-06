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
